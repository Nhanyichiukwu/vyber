<?php

/**
 * @var \App\View\AppView $this
 */
use Cake\Routing\Router;

?>
<div class="col-lg-5 col-md-8 mb-5 mx-auto py-5">
    <div class="card mmhtpn7c">
        <div class="card-body login-card-body">
            <?= $this->Flash->render(); ?>
            <?= $this->Form->create() ?>
            <?php
            $this->Form->unlockField('confirm_password');
            ?>

            <div class="form-group form-group-lg">
                <div class="input-group mb-3">
                    <input type="text" class="border-bottom border-top-0 form-control-plaintext
                    shadow-none<?= (isset($errors['firstname']) ? ' is-invalid border-danger' : '')
                    ?>" name="firstname" value="<?= isset($credentials['firstname']) ?
                        $credentials['firstname'] : '' ?>" placeholder="First Name">
                </div>
                <?php if (isset($errors['firstname'])): ?>
                    <span class="invalid-feedback" role="alert">
                <?php foreach ($errors['firstname'] as $key => $error): ?>
                    <strong><?= __(str_replace('value', 'firstname', $error)) ?></strong>
                <?php endforeach; ?>
            </span>
                <?php endif; ?>
            </div>
            <div class="form-group form-group-lg">
                <div class="input-group mb-3">
                    <input type="text" class="border-bottom border-top-0
                    form-control-plaintext shadow-none<?= (isset($errors['lastname']) ? ' is-invalid border-danger' : '')
                    ?>" name="lastname" value="<?= isset($credentials['lastname']) ?
                        $credentials['lastname'] : '' ?>" placeholder="Lastname">
                </div>
                <?php if (isset($errors['lastname'])): ?>
                    <span class="invalid-feedback" role="alert">
                <?php foreach ($errors['lastname'] as $key => $error): ?>
                    <strong><?= __(str_replace('value', 'lastname', $error)) ?></strong>
                <?php endforeach; ?>
            </span>
                <?php endif; ?>
            </div>
            <div class="form-group form-group-lg">
                <div class="input-group mb-3">
                    <input type="text" class="border-bottom border-top-0
                    form-control-plaintext shadow-none<?= (isset($errors['other_names']) ? ' is-invalid border-danger' :
                        '')
                    ?>" name="other_names"
                           value="<?= isset($credentials['other_names']) ?
                               $credentials['other_names'] : '' ?>" placeholder="Other Names">
                </div>
                <?php if (isset($errors['other_names'])): ?>
                    <span class="invalid-feedback" role="alert">
                    <?php foreach ($errors['other_names'] as $key => $error): ?>
                        <strong><?= __(str_replace('value', 'other_names', $error)) ?></strong>
                    <?php endforeach; ?>
                </span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <h6>Gender:</h6>
                <input type="hidden" name="gender" value="">
                <?= $this->Form->select('gender',
                    [
                        'male' => 'Male',
                        'female' => 'Female',
                        'other' => 'Other',
                        'prefer_not_to_say' => 'Prefer not to say'
                    ],
                    [
                        'class' => 'form-select form-select-sm bg-transparent text-white-200'
                    ]); ?>
                <?php if (isset($errors['gender'])): ?>
                    <span class="invalid-feedback" role="alert">
                        <?php foreach ($errors['gender'] as $key => $error): ?>
                            <strong><?= __($error) ?></strong>
                        <?php endforeach; ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="form-group">
            <h6>Date of Birth:</h6>
                <div class="form-row input-group-lg mb-3">
                    <?php
                    $yearOffset = 1961;
                    $yearsFromOffset = range($yearOffset, date('Y'));
                    ?>
                    <div class="col-auto">
                        <?= $this->Form->year('date_of_birth[year]', [
                            'min' => $yearOffset,
                            'max' => date('Y'),
                            'class' => 'form-select form-control-plaintext border-bottom',
                            'id' => 'select-year',
                            'required' => 'required'
                        ]); ?>
                    </div>
                    <?php
                    $months = ['' => null];
                    $offset = $index = 1;
                    for ($month = $offset; $month <= 12; $month++) {
                        $months[] = (string)date('F', mktime(0,0,0, $month));
                        $index += 1;
                    }
                    ?>
                    <div class="col-auto">
                        <?= $this->Form->select('date_of_birth[month]', $months, [
                            'selected' => null,
                            'class' => 'form-select form-control-plaintext border-bottom',
                            'id' => 'select-month',
                            'required' => 'required'
                        ]); ?>
                    </div>

                    <?php
                    $daysPerMonth = [];

//                    foreach ($yearsFromOffset as $year) {
//                        foreach ($months as $monthIndex => $monthName) {
//                            $daysPerMonth[$monthIndex] = cal_days_in_month(CAL_GREGORIAN,$monthIndex,$year);
//                        }
//                    }

                    $days = ['' => null];
                    $days += range(1, 31);
                    ?>
                    <div class="col-auto">
                        <?= $this->Form->select('date_of_birth[day]', $days, [
                            'class' => 'form-select form-control-plaintext border-bottom',
                            'id' => 'select-day',
                            'required' => 'required'
                        ]); ?>
                    </div>
                    <?php /** <input type="date" class="border-bottom border-top-0 form-control
                    form-control-plaintext shadow-none<?= isset($errors['date']) ? ' is-invalid border-danger'
                        : '' ?>" name="date_of_birth" required autocomplete="false"
                           <?= isset($credentials['date_of_birth']) ? 'value="'.$credentials['date_of_birth']
                        .'"' : '' ?>> **/ ?>
                </div>
                <?php if (isset($errors['date_of_birth'])): ?>
                    <span class="invalid-feedback" role="alert">
                            <?php foreach ($errors['date_of_birth'] as $key => $error): ?>
                                <strong><?= __($error) ?></strong>
                            <?php endforeach; ?>
                        </span>
                <?php endif; ?>
            </div>
            <div class="form-group form-group-lg">
                <div class="input-group mb-3">
                    <input type="text" class="border-bottom border-top-0 form-control-plaintext
                    shadow-none<?= (isset($errors['username']) ? ' is-invalid border-danger' : '')
                    ?>" name="username" value="<?= isset($credentials['username']) ?
                        $credentials['username'] : '' ?>" placeholder="Username">
                </div>
                <?php if (isset($errors['username'])): ?>
                    <span class="invalid-feedback" role="alert">
                <?php foreach ($errors['username'] as $key => $error): ?>
                    <strong><?= __(str_replace('value', 'username', $error)) ?></strong>
                <?php endforeach; ?>
            </span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <div class="mb-3">
                    <input type="password" class="border-bottom form-control-plaintext shadow-none
                    <?= isset($errors['password']) ? ' is-invalid border-danger'
                        : '' ?>" name="password" <?= isset($credentials['password']) ? 'value="'.$credentials['password']
                        .'"' : '' ?> required autocomplete="current-password" placeholder="Password">
                </div>
                <?php if (isset($errors['password'])): ?>
                    <span class="invalid-feedback" role="alert">
                            <?php foreach ($errors['password'] as $key => $error): ?>
                                <strong><?= __($error) ?></strong>
                            <?php endforeach; ?>
                        </span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <div class="mb-3">
                    <input type="password" class="border-bottom form-control-plaintext shadow-none
                    <?= isset($errors['confirm_password']) ? ' is-invalid border-danger'
                        : '' ?>" name="confirm_password" <?= isset($credentials['confirm_password']) ? 'value="'
                        .$credentials['confirm_password']
                        .'"' : '' ?> required autocomplete="current-password"
                           placeholder="Confirm Password">
                </div>
                <?php if (isset($errors['confirm_password'])): ?>
                    <span class="invalid-feedback" role="alert">
                        <?php foreach ($errors['confirm_password'] as $key => $error): ?>
                            <strong><?= __($error) ?></strong>
                        <?php endforeach; ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-app btn-block btn-lg btn-pill">Go Vibely</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?= $this->Html->scriptStart(['block' => 'scriptBottom']);?>

<?= $this->Html->scriptEnd(); ?>
