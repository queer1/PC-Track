<div class="container">
    <form action="<?php Config::get('URL'); ?>login/login" method="post">
        <div class="row">
            <div class="col s12">
                <div class="row">
                    <div class="input-field col s6">
                        <input id="first_name" type="text" class="validate" required="required">
                        <label for="first_name">First Name</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="last_name" type="text" class="validate" required="required">
                        <label for="last_name">Last Name</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <input id="email" type="email" class="validate">
                        <label for="email">Email (Optional)</label>
                    </div>
                    <div class="input-field col s6">
                        <input pattern="\d{3}[\-]\d{3}[\-]\d{4}" id="phone" type="tel" class="validate" required="required">
                        <label for="phone">Phone Number</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="problem" class="materialize-textarea"></textarea>
                        <label for="problem">Problem</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s6">
                        <button type="submit" class="btn waves-effect waves-light">Add PC</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>