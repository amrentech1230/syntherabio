<?php
/**
 * Template Name: Contact Page
 * The front page template for WordPress
 */
get_header()
?>
<!-- =========================
     CONTACT SECTION
========================= -->

<section class="contact-section">

  <!-- HEADER -->
  <div class="contact-header">

    <span class="contact-tag">GET IN TOUCH</span>

    <h2>Contact us</h2>

    <p>
      Concierge support, research questions, wholesale inquiries —
      we’re here.
    </p>

  </div>

  <!-- MAIN -->
  <div class="contact-container">

    <!-- LEFT SIDE -->
    <div class="contact-info">

      <!-- ITEM -->
      <div class="info-item">

        <div class="info-icon">✉</div>

        <div class="info-text">
          <span>EMAIL</span>
          <p>info@syntheratherapeutics.com</p>
        </div>

      </div>

      <!-- ITEM -->
      <!--<div class="info-item">-->

      <!--  <div class="info-icon">☏</div>-->

      <!--  <div class="info-text">-->
      <!--    <span>PHONE</span>-->
      <!--    <p>+1 (888) 555-0144</p>-->
      <!--  </div>-->

      <!--</div>-->

      <!-- ITEM -->
      <!--<div class="info-item">-->

      <!--  <div class="info-icon">◷</div>-->

      <!--  <div class="info-text">-->
      <!--    <span>HOURS</span>-->
      <!--    <p>-->
      <!--      Mon–Fri · 8a–6p PT <br>-->
      <!--      Sat · 9a–2p PT-->
      <!--    </p>-->
      <!--  </div>-->

      <!--</div>-->

      <!-- ITEM -->
      <!--<div class="info-item">-->

      <!--  <div class="info-icon">⌖</div>-->

      <!--  <div class="info-text">-->
      <!--    <span>LAB</span>-->
      <!--    <p>-->
      <!--      1500 Pacific Coast Hwy <br>-->
      <!--      San Diego, CA 92101-->
      <!--    </p>-->
      <!--  </div>-->

      <!--</div>-->

      <!-- MAP -->
      <!--<div class="contact-map">-->

      <!--  <iframe-->
      <!--    src="https://maps.google.com/maps?q=San%20Diego&t=&z=11&ie=UTF8&iwloc=&output=embed"-->
      <!--    loading="lazy">-->
      <!--  </iframe>-->

      <!--</div>-->

    </div>

    <!-- RIGHT SIDE -->
    <div class="contact-form-wrap">

      <form class="contact-form" id="contactForm">
    <div class="form-row">
        <div class="form-group">
            <label>NAME</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>EMAIL</label>
            <input type="email" name="email" required>
        </div>
    </div>

    <div class="form-group">
        <label>INQUIRY</label>
        <select name="inquiry">
            <option>General</option>
            <option>Wholesale</option>
            <option>Research</option>
            <option>Support</option>
        </select>
    </div>

    <div class="form-group">
        <label>SUBJECT</label>
        <input type="text" name="subject" required>
    </div>

    <div class="form-group">
        <label>MESSAGE</label>
        <textarea name="message" required></textarea>
    </div>

    <button type="submit">SEND MESSAGE</button>
</form>

<div id="response"></div>

    </div>

  </div>

</section>
<script>
jQuery(function ($) {

    $('#contactForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'send_contact_email',
                formData: $(this).serialize()
            },
            success: function(response) {
                alert(response);

                if (response == 'success') {
                    $('#contactForm')[0].reset();
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });

});
</script>
<?php
get_footer()
?>