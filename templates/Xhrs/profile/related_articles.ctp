<?php ?>
<section class="card shadow-sm">
    <div class="card-header">
        <h6 class="card-title">Latest about <?= h($account->getFirstName()); ?></h6>
    </div>
    <div class="card-body px-4 pb-0">
    <?php if (isset($articlesAboutUser) && count($articlesAboutUser)): ?>
        <ul class="unstyled pl-0 bow mx-n3">
            <?php foreach ($articlesAboutUser as $article): ?>
            <li class="afv">
                <a class="media px-4 py-3 bg-white">
                    <div class="avatar avatar-xl mr-3"></div>
                    <div class="rw media-body">
                        <?php
                            // Be careful with the codes below. It is a three step
                            // string highlighting method, intended to highlight
                            // words matching the following words and phrases:
                            // 'Full Name', 'username' and 'stagename'
                            $text = '';
                            if (isset($article->body)) {
                                $text = $article->body;
                            } elseif (isset($article->text)) {
                                $text = $article->text;
                            } elseif (isset($article->post_text)) {
                                $text = $article->post_text;
                            }
                        ?>
                        <?= Text::highlight(
                                Text::highlight(
                                    Text::truncate(h($text), 72),
                                $account->getFullname(),
                                ['format' => '<span class="highlight highlight-bold text-dark">\1</span>','html' => true]
                            ),
                            '@'.$account->getUsername(),
                            ['format' => '<span class="highlight highlight-bold text-dark">\1</span>','html' => true]
                        ); ?>
                    </div>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    </div>
    <footer class="card-footer bgc-grey-200">
    <?php
        $person = h($account->getFirstName());
        if (isset($activeUser) && $account->isSameAs($activeUser)) {
            $person = 'you';;
        }
        $numberOfPeopleTalkingAboutUser = count($this->get('peopleTalkingAboutUser') ?? []);
    ?>
        <p class="small">
            There are <strong class="number">(<?= $this->Number->format($numberOfPeopleTalkingAboutUser); ?>)</strong>
            persons <span class="label text-muted-dark">talking about <?= h($person) ?> taday:</span>
        </p>
    <?php if (!isset($activeUser) || !$account->isSameAs($activeUser)): ?>
        <?php if ($numberOfPeopleTalkingAboutUser > 0): ?>
        <p class="small">Join the conversation</p>
        <?php else: ?>
        <p class="small">Be the first to say something about <?= $person ?> today</p>
        <?php endif; ?>
    <?php endif; ?>
    </footer>
</section>
