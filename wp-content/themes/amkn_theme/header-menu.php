

            <div class="mainmenu index"> 
                <?php
                $defaults = array(
                    'container' => 'none',
                    'container_id' => '',
                    'menu_class' => 'Mainmenu',
                    'menu_id' => 'Mainmenu',
                    'theme_location' => 'secondary',//'menu' => '771', // id Main Menu (primary)
                    'echo' => true,
                    'fallback_cb' => 'wp_page_menu',
                    'before' => '',
                    'after' => '',
                    'link_before' => '<span>',
                    'link_after' => '</span>',
                    'depth' => 0,
                    'walker' => '');
                wp_nav_menu($defaults);
                ?> 
            </div><!-- end mainmenu -->
       <div class="borde-menu"> </div>