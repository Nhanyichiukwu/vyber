<?php
use Cake\Routing\Router;
use App\Utility\RandomString;
?>

<div class="d-none visually-hidden _179">
    <div class="form-wrapper">
    <?= $this->Form->create(null, ['url' => '/posts/new-post','id' => 'xhrs-blank-form', 'type' => 'file', 'target' =>
        'ajaxSimulator']); ?>
        <?php $this->Form->input('media', ['type' => 'file', 'id' => 'foo', 'name' => 'bar', 'multiple']); ?>
        <?= $this->Form->input('form_boundary', ['type' => 'hidden', 'id' => 'form_boundary', 'value' => RandomString::generateString(16, 'mixed')]); ?>
        <?php if ($this->get('activeUser')): ?>
        <?= $this->Form->input('uid', ['type' => 'hidden', 'id' => 'uid', 'value' => $activeUser->get('refid')]); ?>
        <?php endif; ?>
        <?php $this->Form->button(__('Send'), ['id' => 'foo', 'name' => 'bar']); ?>
    <?= $this->Form->end(['Upload']); ?>
    </div>

    <metadata class="d-none" style="display: none; max-height: 0; max-width: 0">
        <?php
        $metadata = array(
            'baseUri' => Router::url(['controller' => '/'], true),
            'asxhrh' => Router::url(['controller' => 'AccountServices'], true),
            'currentPage' => $this->getRequest()->getAttribute('here')
        );
        ?>
        <?php
        if (isset($activeUser)) {
            $metadata['account'] = [
                'iuid' => $activeUser->get('refid'),
                'firstname' => $activeUser->getFirstName(),
                'lastname' => $activeUser->getLastName(),
                'othernames' => $activeUser->getOthernames(),
                'username' => $activeUser->getUsername(),
                'email' => $activeUser->getPrimaryEmail(),
                'phone' => $activeUser->getPrimaryPhone(),
                'gender' => $activeUser->getGender(),
//            'dob' => $activeUser->profile->getDOB() ?? null,
//            'maritalStatus' => $activeUser->profile->getMaritalStatus() ?? null,
                'timezone' => ''
            ];
        }
//        echo json_encode($metadata);
        ?>
    </metadata>
</div>
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h6 class="modal-title" id="modalTitle"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
