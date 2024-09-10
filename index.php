<?php
/**
 * Plugin Name: User Test 
 * Description: hello
 * Version: 1.0
 * Author: Rupom
 * Text Domain: 
 * 
 */
// add_action('wp', 'check_url_and_site');

// function check_url_and_site() {
//     if ($_SERVER['REQUEST_URI'] == '/wordpress/') {
//         echo "This is the WordPress page";
//     }
// }

// $args = array(
//     'number' => -1,
// );

// $user_query = new WP_User_Query($args);

// if (!empty($user_query->get_results())) {
//     foreach ($user_query->get_results() as $user) {
//         echo 'User ID: ' . $user->ID . '<br>';
//         echo 'Username: ' . $user->user_login . '<br>';
//         echo 'Email: ' . $user->user_email . '<br>';
        
//         $phone = get_user_meta($user->ID, 'phone_number', true);
//         $address = get_user_meta($user->ID, 'address', true);
        
//         echo 'Phone Number: ' . $phone . '<br>';
//         echo 'Address: ' . $address . '<br><br>';
//     }
// } else {
//     echo 'No users found.';
// }


add_action('admin_menu', 'user_data_menu_page');

function user_data_menu_page() {
    add_menu_page(
        'User Data Page',      
        'User Data',           
        'manage_options',      
        'user-data-slug',      
        'user_data_page_html', 
        'dashicons-admin-users',
        6                    
    );
}
function user_data_page_html() {
    // if (!current_user_can('manage_options')) {
    //     return;
    // }
    ?>
    <div class="data_container">
        <h2>User</h2>
        <?php
    // $users = get_users();
    // foreach ( $users as $user ) {
    //     $user = new WP_User( $user );

    //     echo '<h3>User: ' .  $user->display_name . '</h3>';
    //     echo '<p>User ID: ' .  $user->ID . '</p>';
    //     echo '<p>User Email: ' .  $user->user_email . '</p>';
    //     echo '<p>User Role: ' . implode(', ', $user->roles ) . '</p>';

    //     $user_meta = get_user_meta( $user->ID );
    //     echo '<h4>Meta Data:</h4>';
    //     echo '<ul>';
    //     foreach ( $user_meta as $meta_key => $meta_value ) {
    //         echo '<li><strong>' . print_r($meta_value) . '</li>';
    //     }
    //     echo '</ul>';
    // }

        $user_data_query = new WP_User_Query( array( 'role' => 'Administrator' ) );

        if ( ! empty( $user_data_query->get_results() ) ) {
        //     // print_r($user_data_query->get_results()[0]);
            $single_user_data = $user_data_query->get_results()[0];
            echo '<h3>' . $single_user_data->user_email . '</h3>';
            foreach ( $user_data_query->get_results() as $a_user ) {
                $a_user_id = $a_user->ID;
               ?>
               <p><?php echo $a_user->ID ?></p>
               <p><?php echo $a_user->user_email ?></p>
               <p><?php echo $a_user->user_login ?></p>
               <p><?php echo implode(',', $a_user->roles) ?></p>
               <p><?php echo implode(',', $a_user->caps) ?></p>
               <p><?php echo $a_user->first_name ?></p>
               <p><?php echo $a_user->last_name ?></p>
                <?php

               // Billing data
                $billing_first_name = get_user_meta( $a_user_id, 'billing_first_name', true );
                $billing_last_name  = get_user_meta( $a_user_id, 'billing_last_name', true );
                $billing_address_1  = get_user_meta( $a_user_id, 'billing_address_1', true );
                $billing_address_2  = get_user_meta( $a_user_id, 'billing_address_2', true );
                $billing_city       = get_user_meta( $a_user_id, 'billing_city', true );
                $billing_postcode   = get_user_meta( $a_user_id, 'billing_postcode', true );
                $billing_country    = get_user_meta( $a_user_id, 'billing_country', true );
                $billing_state      = get_user_meta( $a_user_id, 'billing_state', true );
                // $billing_phone      = get_user_meta( $a_user_id, 'billing_phone', true );
                $billing_email      = get_user_meta( $a_user_id, 'billing_email', true );
                ?>
                <div class="billing_content">
                    <p><?php echo $billing_address_1 ?></p>
                    <p><?php echo $billing_address_1 ?></p>
                    <p><?php echo $billing_city ?></p>
                    <p><?php echo $billing_country . $billing_state . $billing_postcode ?></p>
                </div>
                <?php
                // Shipping data 
                $shipping_first_name = get_user_meta( $a_user_id, 'shipping_first_name', true );
                $shipping_last_name  = get_user_meta( $a_user_id, 'shipping_last_name', true );
                $shipping_address_1  = get_user_meta( $a_user_id, 'shipping_address_1', true );
                // $shipping_address_2  = get_user_meta( $a_user_id, 'shipping_address_2', true );
                // $shipping_city       = get_user_meta( $a_user_id, 'shipping_city', true );
                $shipping_postcode   = get_user_meta( $a_user_id, 'shipping_postcode', true );
                $shipping_country    = get_user_meta( $a_user_id, 'shipping_country', true );
                $shipping_state      = get_user_meta( $a_user_id, 'shipping_state', true );
                ?>
                <div class="shipping_content">
                    <p><?php echo $shipping_first_name ?></p>
                    <p><?php echo $shipping_last_name ?></p>
                    <p><?php echo $shipping_city ?></p>
                    <p><?php echo $shipping_country . $shipping_state?></p>
                </div>
            <?php
            }

        } else {
            echo 'No user';
        }
        ?>

    </div>

    <div class="user_by_metavalue">
    <?php 
    $user_meta_query = new WP_User_Query( array( 
        'meta_key'   => 'billing_state', 
        'meta_value' => 'England',
        'compare'    => '=' 
    ) );

    if ( ! empty( $user_meta_query->get_results() ) ) {
        foreach ( $user_meta_query->get_results() as $a_user ) {
            ?>
            <p>User ID: <?php echo $a_user->ID; ?></p>
            <p>Email: <?php echo $a_user->user_email; ?></p>
            <p>Username: <?php echo $a_user->user_login; ?></p>
            <?php
        }
    }
    ?>
</div>

    <?php
}
