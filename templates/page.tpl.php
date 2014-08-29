<div id="page" class="<?php print $classes; ?>"<?php print $attributes; ?>>

    <header id="header" class="clearfix" role="header">
        <div class="container">

        <?php if ($logo): ?>
            <div id="logo">
                <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home">
                    <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>"/>
                </a>
            </div>
        <?php endif; ?>

        <?php if ($site_name): ?>
            <div id="site-name"><?php print $site_name; ?></div>
        <?php endif; ?>

        <?php if ($secondary_menu): ?>
            <nav id="secondary-menu" class="menu navigation clearfix">
                <?php print theme('links', array('links' => $secondary_menu, 'attributes' => array('class' => array('links')))); ?>
            </nav>
        <?php endif; ?>

        <?php print render($page['header']); ?>

        <?php if ($main_menu): ?>
            <nav id="main-menu" class="menu navigation clearfix">
                <?php print theme('links', array('links' => $main_menu, 'attributes' => array('class' => array('links')))); ?>
            </nav>
        <?php endif; ?>

        </div>
    </header>

    <section id="main" class="clearfix" role="main">

        <div id="content-header">
            <div class="container">
                <?php if ($title && !$is_panel): ?>
                    <?php print render($title_prefix); ?>
                    <h1><?php print $title; ?></h1>
                    <?php print render($title_suffix); ?>
                <?php endif; ?>

                <?php if ($breadcrumb): ?>
                    <div id="breadcrumb"><?php print $breadcrumb; ?></div>
                <?php endif; ?>

                <?php if ($messages): ?>
                    <div id="messages"><?php print $messages; ?></div>
                <?php endif; ?>

                <?php if ($tabs): ?>
                    <div class="tabs"><?php print render($tabs); ?></div>
                <?php endif; ?>

                <?php if ($action_links): ?>
                    <ul class="action-links"><?php print render($action_links); ?></ul>
                <?php endif; ?>
            </div>
        </div>

        <div id="content" class="<?php print (!$is_panel) ? 'container' : ''; ?>">
            <?php print render($page['content']); ?>
        </div>

    </section>

    <footer id="footer" class="clearfix" role="footer">
        <div class="container">
            <?php print render($page['footer']); ?>
        </div>
    </footer>

</div>
