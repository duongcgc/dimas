<# if ( data.depth == 0 ) { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Mega Menu Content', 'dimas' ) ?>"
   data-panel="mega"><?php esc_html_e( 'Mega Menu', 'dimas' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Mega Menu Background', 'dimas' ) ?>"
   data-panel="background"><?php esc_html_e( 'Background', 'dimas' ) ?></a>
<div class="separator"></div>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Badges', 'dimas' ) ?>"
   data-panel="badges"><?php esc_html_e( 'Badges', 'dimas' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'dimas' ) ?>"
   data-panel="icon"><?php esc_html_e( 'Icon', 'dimas' ) ?></a>
<# } else if ( data.depth == 1 ) { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Content', 'dimas' ) ?>"
   data-panel="content"><?php esc_html_e( 'Menu Content', 'dimas' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu General', 'dimas' ) ?>"
   data-panel="general"><?php esc_html_e( 'General', 'dimas' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Badges', 'dimas' ) ?>"
   data-panel="badges"><?php esc_html_e( 'Badges', 'dimas' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'dimas' ) ?>"
   data-panel="icon"><?php esc_html_e( 'Icon', 'dimas' ) ?></a>
<# } else { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu General', 'dimas' ) ?>"
   data-panel="general_2"><?php esc_html_e( 'General', 'dimas' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Badges', 'dimas' ) ?>"
   data-panel="badges"><?php esc_html_e( 'Badges', 'dimas' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'dimas' ) ?>"
   data-panel="icon"><?php esc_html_e( 'Icon', 'dimas' ) ?></a>
<# } #>
