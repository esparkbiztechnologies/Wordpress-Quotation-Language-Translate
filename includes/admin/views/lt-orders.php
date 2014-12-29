<?php

/**
 * Orders Page
 * Handles to orders
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Order List Page
 *
 * The html markup for the product list
 */

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
	
class Lt_Order_List extends WP_List_Table {

    function __construct(){
                
        //Set parent defaults
        parent::__construct( array(
                                        'singular'  => 'ltsale',     //singular name of the listed records
                                        'plural'    => 'ltsales',    //plural name of the listed records
                                        'ajax'      => false        //does this table support ajax?
                                    ) );
    }
    
    /**
    * Displaying Prodcuts
    *
    * Does prepare the data for displaying the products in the table.
    */	
   function display_orders() {

           //if search is call then pass searching value to function for displaying searching values
           $args = array();

           $prefix = LT_META_PREFIX;

           //get orders data from database
           $data = lt_get_orders( $args );

           foreach ($data as $key => $value){

                //get user email
                $data[$key]['user_email'] = get_post_meta( $value['ID'], $prefix . 'user_email', true  );
                
                //get all items
                $data[$key]['items'] = get_post_meta( $value['ID'], $prefix . 'file_data', true  );
                
                //get selected langs
                $data[$key]['lang_from'] = get_post_meta( $value['ID'], $prefix . 'tran_from', true  );
                $data[$key]['lang_to'] = get_post_meta( $value['ID'], $prefix . 'tran_to', true  );
                
                //get translate level
                $level = get_post_meta( $value['ID'], $prefix . 'translate_level', true  );
                $data[$key]['level'] = !empty( $level ) ? $level : 'standard';
           }

           return $data;
   }
	
    /**
     * Mange column data
     *
     * Default Column for listing table
     */
    function column_default( $item, $column_name ){

        switch( $column_name ){
            case 'ID':
            case 'user_email':
                return $item[ $column_name ];
            case 'items':
                $all_items = '';
                if( !empty( $item[ $column_name ] ) ) {
                    foreach ( $item[ $column_name ] as $content_data ) {
                        if( $content_data['method'] == 'file' ) {
                            $all_items .= '<p>'.__( 'File URL', 'langtrans' ).'</p>';
                            $all_items .= !empty( $content_data['url'] ) ? '<a target="_BLANK" href="'.$content_data['url'].'">'.__( 'File', 'langtrans' ).'</a>' : '';
                        } else {
                            $all_items .= '<p>'.__( 'Text', 'langtrans' ).'</p>';
                            $all_items .= !empty( $content_data['content'] ) ? nl2br( $content_data['content'] ) : '';
                        }
                    }
                }
                return $all_items;
            case 'lang_from':
                return !empty( $item[ $column_name ] ) ? get_the_title( $item[ $column_name ] ) : '';
            case 'lang_to':
                $lang_to = array();
                if( !empty( $item[ $column_name ] ) ) {
                    foreach ( $item[ $column_name ] as $lang_to_id ) {
                        $lang_to[] = get_the_title( $lang_to_id );
                    }
                }
                return implode( ', ', $lang_to );
            case 'level' :
                return ucfirst( $item[ $column_name ] );
            case 'date_time' :
                $datetime = lt_get_date_format($item[ $column_name ],true);
                return $datetime;
            default:
                return $item[ $column_name ];
        }
    }
	    
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id
        );
    }
    
    /**
     * Display Columns
     *
     * Handles which columns to show in table
     */
    function get_columns(){
	
        $columns = array(
                            //'cb'          =>	'<input type="checkbox" />', //Render a checkbox instead of text
                            'ID'            =>	__( 'Order ID', 'langtrans' ),
                            'user_email'    =>	__( 'User Email', 'langtrans' ),
                            'items'         =>	__( 'Items', 'langtrans' ),
                            'lang_from'     =>	__( 'Language From', 'langtrans' ),
                            'lang_to'       =>	__( 'Language To', 'langtrans' ),
                            'level'         =>	__( 'Level', 'langtrans' ),
                            'date_time'     =>	__( 'Date/Time', 'langtrans' ),
                        );
        return $columns;
    }
	
    /**
     * Sortable Columns
     *
     * Handles soratable columns of the table
     */
	function get_sortable_columns() {
		
		
        $sortable_columns = array(
                                        'ID'            => array( 'ID', true ),
                                        'user_email'    => array( 'user_email', true ),     //true means its already sorted
                                        'date_time'	=> array( 'date_time', true )
                                    );
        return $sortable_columns;
    }
	
    function no_items() {
            //message to show when no records in database table
            _e( 'No orders found.', 'langtrans' );
    }

    /**
     * Bulk actions field
     *
     * Handles Bulk Action combo box values
     */
    function get_bulk_actions() {
        //bulk action combo box parameter
        //if you want to add some more value to bulk action parameter then push key value set in below array
        $actions = array(
                            );
        return $actions;
    }
    
	
    function prepare_items() {

        /**
         * First, lets decide how many records per page to show
         */
        $per_page = '10';
       
        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        
        /**
         * REQUIRED. Finally, we build an array to be used by the class for column 
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array($columns, $hidden, $sortable);
        
         /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        //$this->process_bulk_action();
        
        /**
         * Instead of querying a database, we're going to fetch the example data
         * property we created for use in this plugin. This makes this example 
         * package slightly different than one you might build on your own. In 
         * this example, we'll be using array manipulation to sort and paginate 
         * our data. In a real-world implementation, you will probably want to 
         * use sort and pagination data to build a custom query instead, as you'll
         * be able to use your precisely-queried data immediately.
         */
        $data = $this->display_orders();

        /**
         * This checks for sorting input and sorts the data in our array accordingly.
         * 
         * In a real-world situation involving a database, you would probably want 
         * to handle sorting by passing the 'orderby' and 'order' values directly 
         * to a custom query. The returned data will be pre-sorted, and this array
         * sorting technique would be unnecessary.
         */
        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'ID'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'desc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
        }
        usort($data, 'usort_reorder');

        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently 
         * looking at. We'll need this later, so you should always include it in 
         * your own package classes.
         */
        $current_page = $this->get_pagenum();
        
        /**
         * REQUIRED for pagination. Let's check how many items are in our data array. 
         * In real-world use, this would be the total number of items in your database, 
         * without filtering. We'll need this later, so you should always include it 
         * in your own package classes.
         */
        $total_items = count($data);
        
        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to 
         */
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);        
        
        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where 
         * it can be used by the rest of the class.
         */
        $this->items = $data;
        
        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
                                            'total_items' => $total_items,                  //WE have to calculate the total number of items
                                            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
                                            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
                                        ) );
    }   
}

//Create an instance of our package class...
$LtOrderListTable = new Lt_Order_List();
	
//Fetch, prepare, sort, and filter our data...
$LtOrderListTable->prepare_items();
		
?>

<div class="wrap">
    
    <h2><?php _e( 'Orders', 'langtrans' ); ?></h2>
    
    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
    <form id="product-filter" method="get" class="lt-orders-form">
        
    	<!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <input type="hidden" name="post_type" value="<?php echo LT_CONV_POST_TYPE; ?>" />
		
        <!-- Search Title -->
        <?php //$LtOrderListTable->search_box( __( 'Search', 'langtrans' ), 'langtrans' ); ?>
        
        <!-- Now we can render the completed list table -->
        <?php $LtOrderListTable->display(); ?>
        
    </form>
</div><!--wrap-->