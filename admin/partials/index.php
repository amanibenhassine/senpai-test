<h2>Contactez-nous</h2>
<br>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
    <form id="custom-form" method="post" data-url="<?php admin_url('admin-ajax.php')?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name"><br><br>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email"><br><br>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone"><br><br>

            <label for="message">Message:</label>
            <textarea id="message" name="message"></textarea><br><br>

            <input type="submit" id="custom-form-submit" value="Submit">
        </form>
    </main>
</div>