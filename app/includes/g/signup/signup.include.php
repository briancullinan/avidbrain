<div class="findatutor-container">
    <div class="pagesTitle">
        <h1>Math Tutoring in Phoenix</h1>
        <h2>Teach Something. Learn Anything.</h2>
    </div>
</div>

<div class="row">
    <div class="col s12 m8 l8">

        <div class="block gsignup-block">
            <p>At MindSpree, we understand that gaining fundamental math skills early on will help students succeed throughout their lives. Our tutors help students overcome roadblocks and help them exceed standards.</p>

            <p>While our students come from a walks of lives, our tutors are all interviewed and background check to ensure quality and safety.</p>


            <ul>
                <div><strong>Benefits of MindSpree</strong></div>
                <li>
                    Be tutored online or in-person
                </li>
                <li>
                    Choose a tutor that works for you
                </li>
                <li>
                    Tutors work around your schedule
                </li>
                <li>
                    Prices for all budgets
                </li>
                <li>
                    All tutors are interviewed and background checked
                </li>
                <li>
                    No long term contracts
                </li>
                <li>
                    No sign up cost
                </li>
                <li>
                    First hour guarantee
                </li>
            </ul>
        </div>

    </div>
    <div class="col s12 m4 l4">

        <div class="block tutor-block gsignup-form">
            <form class="form-post" action="/signup/student" method="post" id="studentsignup">
                <div class="signup-title">
                    Sign Up Now and Get a $30 credit
                </div>

                <div class="new-inputs">
                    <div class="row">

                        <div class="col s12 m6 l6">
                            <div class="input-wrapper" id="ts_first_name"><input type="text" name="studentsignup[student][first_name]" autofocus="autofocus" placeholder="First Name" /></div>
                        </div>

                        <div class="col s12 m6 l6">
                            <div class="input-wrapper" id="ts_last_name"><input type="text" name="studentsignup[student][last_name]" placeholder="Last Name" /></div>
                        </div>

                    </div>
                </div>

                <div class="new-inputs">
                    <div class="row">

                        <div class="col s12 m12 l12">
                            <div class="input-wrapper" id="ts_email"><input type="email" name="studentsignup[student][email]" placeholder="Email Address" /></div>
                        </div>

                    </div>
                </div>

                <div class="new-inputs">
                    <div class="row">

                        <div class="col s12 m12 l12">
                            <div class="input-wrapper" id="ts_password"><input type="password" name="studentsignup[student][password]" placeholder="Password (At least 6 characters)" /></div>
                        </div>

                    </div>
                </div>

                <div class="new-inputs">
                    <div class="row">

                        <div class="col s12 m12 l12">
                            <div class="input-wrapper" id="ts_zipcode"><input type="text" name="studentsignup[student][zipcode]" placeholder="Your Zip Code" /></div>
                        </div>

                    </div>
                </div>

                <div class="new-inputs">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <button class="btn btn-l btn-block">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>

                <div class="new-inputs">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="the-disclaimer">
                                By signing up I agree that MindSpree may contact me by email, phone, or SMS at the email address or number I provide. I have read, understand and agree to the <a href="/terms-of-use" target="_blank">Terms of Service</a>.
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="studentsignup[student][phone]" placeholder="Phone Number"  value="666-666-6666"/>

                <input type="hidden" name="studentsignup[target]" value="studentsignup"  />
                <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
            </form>
        </div>

    </div>
</div>


<style type="text/css">
.findatutor-container{
    position: relative;
}
.findatutor-container h1, .findatutor-container h2{
    color: #fff;
    background: rgba(0, 0, 0, 0.61);
    display: inline-block;
    clear: both;
    padding: 10px;
}
.mainsignup main {
    background: url('/images/subs/become-a-student.jpg') top left no-repeat;
}
.gsignup-block{
    min-height: 500px;
    border: none;
}
.gsignup-block ul{
    margin: 0px;
    padding:10px 20px;
    color: #fff;
    background: #7ac143;
    border-top: solid 5px #0099ff;
}
.gsignup-block ul li{
    list-style-type: disc;
    margin-left: 20px;
}
.gsignup-form{
    /*margin-top: 100px;*/
}
</style>


<?php if(isset($app->purechat)): ?>
	<script type='text/javascript' data-cfasync='false'>window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: 'a450183c-ea47-4537-89d4-f8b55a44e006', f: true }); done = true; } }; })();</script>
<?php endif; ?>
