<?php
/**
 * Basic Layout Bottom
 *
 * All Layouts except the auth screen, must include this file at the bottom and
 * the corresponding layout top at the top.
 */
?>
                </div>
            </main>
        </div>
        <span class="d-none">
        <?php $this->prepend('manifest', '<manifest name="baseuri">' . $this->getRequest()->getAttribute('base') . '</manifest>'); ?>
        <?= $this->fetch('manifest'); ?>
        </span>
        <?= $this->element('Widgets/hidden_widgets'); ?>

        <?= $this->Html->script('vendor/jQuery/jquery.min'); ?>
        <?= $this->Html->script('vendor/jQuery/jquery.cookie'); ?>
        <?= $this->Html->script('vendor/jQuery/jquery.form'); ?>
        <?= $this->Html->script('vendor/bootstrap/bootstrap.bundle.min'); ?>
        <?= $this->Html->script('utils.js?token='. date('Ymdhis')); ?>
        <script>
//            let META_DATA;
//            META_DATA = $.parseJSON($('metadata').text());

//            $(function(){
                // Enables popover, tooltip
//                $('[data-toggle="popover"]').popover();
//                $('[data-toggle="tooltip"]').tooltip();
//
//                enableDisplayToggle();
//            });
        </script>
        <?= $this->Html->script('app.js'); ?>
        <?= $this->Html->script('AsyncAccountService.js', ['charset' => 'utf-8']); ?>
        <?= $this->fetch('scriptBottom'); ?>
    </body>
</html>

