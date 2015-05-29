<div id="main" class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <?php $this->renderFeedbackMessages(); ?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">LoginController/showProfile</h1>
        </div>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="box">
                <h2>Your profile</h2>

                <!-- echo out the system feedback (error and success messages) -->
                <?php $this->renderFeedbackMessages(); ?>

                <div>Your username: <?= $this->user_name; ?></div>
                <div>Your email: <?= $this->user_email; ?></div>
                <div>Your avatar image:
                    <?php if(Config::get('USE_GRAVATAR')) { ?>
                        Your gravatar pic (on gravatar.com): <img src='<?= $this->user_gravatar_image_url; ?>'/>
                    <?php } else { ?>
                        Your avatar pic (saved locally): <img src='<?= $this->user_avatar_file; ?>'/>
                    <?php } ?>
                </div>
                <div>Your account type is: <?= $this->user_account_type; ?></div>
            </div>
        </div>
        <!--/.row-->
    </div>






