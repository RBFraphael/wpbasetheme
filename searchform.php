<?php if(!defined('ABSPATH')){ exit; } ?>
<form action="<?= get_bloginfo('url'); ?>" method="get">
    <div class="input-group">
        <input type="text" name="s" id="s" class="form-control" required="required" value="<?= get_search_query(); ?>" placeholder="Pesquisar...">
        <div class="input-group-append">
            <button type="submit" class="btn btn-dark"><i class="fas fa-search"></i></button>
        </div>
    </div>
</form>