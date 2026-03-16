<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <?php echo $this->Html->script('jquery311min.js'); ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><a href=""><?= __($this->fetch('title')) ?></a></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
                <li><?= $this->Html->link(__('Races'), ['controller'=>'races','action' => 'index']) ?></li>
                <li><?= $this->Html->link(__('Contestants'), ['controller'=>'contestants','action' => 'index']) ?></li>
                <li><?= $this->Html->link("|",[]);?></li>
                <li><?= $this->Html->link(__('Modify {0}',[__("Race Contestants")]), ['controller'=>'race_contestants','action' => 'add']) ?></li>
                <li><?= $this->Html->link(__('Register {0}',[__('Contestant Laps')]), ['controller'=>'contestant_laps','action' => 'add']) ?></li>
                <li><?= $this->Html->link(__('Register {0}',[__('Contestant finishtime')]), ['controller'=>'contestant_finishtimes','action' => 'add']) ?></li>
                <li><?= $this->Html->link("|",[]);?></li>
                <li><?= $this->Html->link(__('Statistics'), ['controller'=>'statistics','action' => 'index']) ?></li>
            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
