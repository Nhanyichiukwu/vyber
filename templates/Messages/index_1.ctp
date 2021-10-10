<?php

?>
<div class="chat-list">
<?php if (count($chats)): ?>
    <?php foreach ($chats as $chat): ?>
    <div class="chat">
        <div class="user-img">
            <img class="avatar-lg" src="" alt="">
        </div>
        <div class="notification-info">
            <h3><a href="messages.html" title="">rwlrwlkrtlw</a> </h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do.</p>
            <span>2 min ago</span>
        </div><!--notification-info -->
    </div>
    <?php endforeach; ?>
    
    <div class="notfication-details">
        <div class="noty-user-img">
            <img src="images/resources/ny-img2.png" alt="">
        </div>
        <div class="notification-info">
            <h3><a href="messages.html" title="">Jassica William</a></h3>
            <p>Lorem ipsum dolor sit amet.</p>
            <span>2 min ago</span>
        </div><!--notification-info -->
    </div>
    <div class="notfication-details">
        <div class="noty-user-img">
            <img src="images/resources/ny-img3.png" alt="">
        </div>
        <div class="notification-info">
            <h3><a href="messages.html" title="">Jassica William</a></h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempo incididunt ut labore et dolore magna aliqua.</p>
            <span>2 min ago</span>
        </div><!--notification-info -->
    </div>
    <div class="view-all-nots">
        <a href="messages.html" title="">View All Messsages</a>
    </div>
    <?php else: ?>
    <p>Your chat history is empty</p>
    <?php endif; ?>
</div>