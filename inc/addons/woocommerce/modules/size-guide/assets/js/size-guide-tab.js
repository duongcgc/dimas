jQuery( document ).ready( function( $ ) {
	$( '.dimas-size-guide-tabs' ).on( 'click', '.dimas-size-guide-tabs__nav li', function() {
        var $tab = $( this ),
            index = $tab.data( 'target' ),
            $panels = $tab.closest( '.dimas-size-guide-tabs' ).find( '.dimas-size-guide-tabs__panels' ),
            $panel = $panels.find( '.dimas-size-guide-tabs__panel[data-panel="' + index + '"]' );

        if ( $tab.hasClass( 'active' ) ) {
            return;
        }

        $tab.addClass( 'active' ).siblings( 'li.active' ).removeClass( 'active' );

        if ( $panel.length ) {
            $panel.addClass( 'active' ).siblings( '.dimas-size-guide-tabs__panel.active' ).removeClass( 'active' );
        }
    } );
} );