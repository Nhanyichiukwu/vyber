<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$tab = $this->Url->request->getQuery('action');
if (!$tab) $tab = 'default';
$profileUrl = '/u/' . h($account->username);
?>
    <div class="cover-image pos-r">

    </div>