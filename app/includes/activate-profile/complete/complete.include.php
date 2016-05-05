<?php if(isset($app->user->qasignup)): ?>
<p>Thank you for activating your profile. You may now start asking questions at MindSpree Q&A.</p>
<p>
    <a class="btn blue white-text" href="/qa-login">Visit Q&A</a>
</p>
<?php else: ?>
<p>Thank you for activating your profile. Now lets find the help you need.</p>
<div class="activate-complete">
    <div class="activate-complete-left valign-wrapper">
        <a class="valign" href="/jobs">You Can Request A Tutoring Session</a>
    </div>
    <div class="activate-complete-middle">
        OR
    </div>
    <div class="activate-complete-right valign-wrapper">
        <a class="valign" href="/tutors">You Can Search For A Tutor</a>
    </div>
</div>

<?php endif; ?>
