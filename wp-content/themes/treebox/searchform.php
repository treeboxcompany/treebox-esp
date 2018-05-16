<form role="search" method="get" id="searchform" class="searchform col-12 col-sm-12 col-md-4" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div>
        <input type="text" class="text-input" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="Busca un artículo"/>
        <input type="submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" />
    </div>
</form>
