<?php
/**
 * Template Name: Home Page
 * The front page template for WordPress
 */
get_header();
?>
<!-- HERO SECTION -->
<section class="hero-section" style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/image/hero-section.jpeg');">
  <div class="hero-overlay"></div>
  <div class="hero-particles"></div>

  <div class="hero-container">
    <!-- LEFT CONTENT -->
    <div class="hero-content">
      <span class="hero-badge">
        RESEARCH-GRADE • THIRD-PARTY TESTED
      </span>

      <h1 class="hero-title">Advancing <span>Science.</span><br>Optimizing <span class="light">Health.</span></h1>

      <p class="hero-description">
        A premium peptide, supplement, and research compound laboratory.
        Engineered to clinical standards, validated by independent labs,
        delivered with discretion.
      </p>

      <div class="hero-buttons">
        <a href="<?php echo site_url('shop');?>" class="btn-primary">
          SHOP NOW →
        </a>


      </div>

      <div class="hero-stats">
        <div class="stat">
          <h3>99%+</h3>
          <p>PURITY</p>
        </div>

        <div class="stat">
          <h3>3rd</h3>
          <p>PARTY TESTED</p>
        </div>

        <div class="stat">
          <h3>48h</h3>
          <p>DISPATCH</p>
        </div>
      </div>
    </div>

    <!-- RIGHT FLOATING CARDS -->
    <!--<div class="hero-cards">-->
    <!--  <div class="product-card card-1">-->
    <!--    <span>PEPTIDES</span>-->
    <!--    <h4>CJC-1295 5mg</h4>-->
    <!--    <p>$79.00</p>-->
    <!--  </div>-->

    <!--  <div class="product-card card-2">-->
    <!--    <span>WELLNESS</span>-->
    <!--    <h4>Collagen Support Complex</h4>-->
    <!--    <p>$49.00</p>-->
    <!--  </div>-->

    <!--  <div class="product-card card-3">-->
    <!--    <span>PEPTIDES</span>-->
    <!--    <h4>BPC-157 5mg</h4>-->
    <!--    <p>$69.00</p>-->
    <!--  </div>-->
    <!--</div>-->
  </div>
</section>

<!-- CATEGORIES SECTION -->
<!--<section class="categories-section">-->

<!--  <div class="categories-container">-->

    <!-- SECTION TOP -->
<!--    <div class="section-heading">-->
<!--      <span class="section-label">CATEGORIES</span>-->
<!--      <h2>Curated by purpose</h2>-->
<!--    </div>-->

    <!-- CATEGORY GRID -->
<!--    <div class="categories-grid">-->

      <!-- CARD 1 -->
<!--      <div class="category-card">-->
<!--        <div class="category-number">01</div>-->

<!--        <h3>Peptides</h3>-->

<!--        <p>-->
<!--          Premium research peptides synthesized to the highest standards.-->
<!--        </p>-->

<!--        <a href="#" class="category-arrow">-->
<!--          →-->
<!--        </a>-->
<!--      </div>-->

      <!-- CARD 2 ACTIVE -->
<!--      <div class="category-card">-->
<!--        <div class="category-number">02</div>-->

<!--        <h3>Wellness</h3>-->

<!--        <p>-->
<!--          Daily wellness formulations to support whole-body health.-->
<!--        </p>-->

<!--        <a href="#" class="category-arrow">-->
<!--          →-->
<!--        </a>-->
<!--      </div>-->

      <!-- CARD 3 -->
<!--      <div class="category-card">-->
<!--        <div class="category-number">03</div>-->

<!--        <h3>Recovery</h3>-->

<!--        <p>-->
<!--          Targeted recovery support for active lifestyles.-->
<!--        </p>-->

<!--        <a href="#" class="category-arrow">-->
<!--          →-->
<!--        </a>-->
<!--      </div>-->

      <!-- CARD 4 -->
<!--      <div class="category-card">-->
<!--        <div class="category-number">04</div>-->

<!--        <h3>Performance</h3>-->

<!--        <p>-->
<!--          Performance-enhancing compounds for peak output.-->
<!--        </p>-->

<!--        <a href="#" class="category-arrow">-->
<!--          →-->
<!--        </a>-->
<!--      </div>-->

      <!-- CARD 5 -->
<!--      <div class="category-card">-->
<!--        <div class="category-number">05</div>-->

<!--        <h3>Research Compounds</h3>-->

<!--        <p>-->
<!--          Reference standards for laboratory research use only.-->
<!--        </p>-->

<!--        <a href="#" class="category-arrow">-->
<!--          →-->
<!--        </a>-->
<!--      </div>-->

<!--    </div>-->

<!--  </div>-->

<!--</section>-->

<section class="featured-products">
    <div class="featured-container">

        <div class="featured-top">
            <div class="featured-heading">
                <span>FEATURED PRODUCTS</span>
                <h2>The flagship line</h2>
            </div>
            <a href="<?php echo get_permalink( wc_get_page_id('shop') ); ?>" class="view-all">VIEW ALL →</a>
        </div>

        <!-- FILTER TABS -->
        <div class="product-filter-tabs">
            <button class="filter-tab active" data-cat="0">All</button>
            <?php
            $cats = get_terms('product_cat', array('hide_empty' => true, 'parent' => 0));
            foreach ($cats as $cat) :
            ?>
            <button class="filter-tab" data-cat="<?php echo $cat->term_id; ?>"><?php echo esc_html($cat->name); ?></button>
            <?php endforeach; ?>
        </div>

        <!-- GRID -->
        <div class="featured-grid" id="featured-products-grid">
        <?php
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 8,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        $products = new WP_Query($args);
        if ($products->have_posts()) :
            while ($products->have_posts()) :
                $products->the_post();
                global $product;
                if (!$product) continue;
                get_template_part('template-parts/product-card');
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>No products found.</p>';
        endif;
        ?>
        </div>

    </div>
</section>
<section class="science-section">

  <div class="science-container">

    <!-- HEADING -->
    <div class="science-heading">

      <span>WHY SYNTHERA</span>

      <h2>Built on rigorous science</h2>

    </div>

    <!-- GRID -->
    <div class="science-grid">

      <!-- ITEM -->
      <div class="science-card">

        <div class="science-icon">
          🧪
        </div>

        <h3>Research-Grade Quality</h3>

        <p>
          Every batch synthesized to ≥99% purity in cGMP-aligned facilities.
        </p>

      </div>

      <!-- ITEM -->
      <div class="science-card">

        <div class="science-icon">
          🛡
        </div>

        <h3>Third-Party Tested</h3>

        <p>
          Independent HPLC and mass-spec analysis with each lot.
        </p>

      </div>

      <!-- ITEM -->
      <div class="science-card">

        <div class="science-icon">
          🔒
        </div>

        <h3>Secure Checkout</h3>

        <p>
          PCI-DSS compliant. End-to-end encryption on every transaction.
        </p>

      </div>

      <!-- ITEM -->
      <div class="science-card">

        <div class="science-icon">
          🚚
        </div>

        <h3>Fast Discreet Shipping</h3>

        <p>
          Same-day dispatch on orders before 2pm. Plain packaging.
        </p>

      </div>

      <!-- ITEM -->
      <div class="science-card">

        <div class="science-icon">
          🎖
        </div>

        <h3>Trusted Formulations</h3>

        <p>
          Standards developed alongside clinicians and researchers.
        </p>

      </div>

      <!-- ITEM -->
      <div class="science-card">

        <div class="science-icon">
          🎧
        </div>

        <h3>Customer Support</h3>

        <p>
          Knowledgeable concierge support — real humans, fast replies.
        </p>

      </div>

    </div>

  </div>

</section>

<section style="padding:110px 20px;background:#f4f5f6;font-family:'Inter',sans-serif;overflow:hidden;">

  <div style="max-width:1180px;margin:0 auto;">

  <!-- ROW 1: IMAGE LEFT / TEXT RIGHT -->
  <div class="science-row" style="
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:80px;
    align-items:center;
    margin-bottom:70px;
  ">

    <!-- IMAGE -->
    <div style="

    ">

      <!-- IMAGE / ICON -->
      <img 
        src="https://syntheratherapeutics.com/wp-content/uploads/2026/09/image-48.png"
        alt="Recovery Science"
        style="
          width:100%;
          height:378px;
          object-fit:cover;
          display:block;
        "
      >

      <!-- LABEL -->
      <!--<div style="-->
      <!--  position:absolute;-->
      <!--  left:16px;-->
      <!--  right:16px;-->
      <!--  bottom:18px;-->
      <!--  border:1px solid rgba(255,255,255,.15);-->
      <!--  background:rgba(255,255,255,.06);-->
      <!--  padding:14px 18px;-->
      <!--  color:#d7e7ea;-->
      <!--  font-size:11px;-->
      <!--  letter-spacing:2px;-->
      <!--  text-transform:uppercase;-->
      <!--  font-weight:600;-->
      <!--">-->
      <!--  ● LOT CERTIFIED-->
      <!--</div>-->

    </div>


    <!-- TEXT -->
    <div>

      <span style="
        color:#00788b;
        font-size:11px;
        font-weight:700;
        letter-spacing:3px;
        text-transform:uppercase;
        display:block;
        margin-bottom:16px;
      ">
        Recovery Science
      </span>

      <h2 style="
        font-size:58px;
        line-height:1.05;
        color:#051220;
        margin:0 0 24px;
        font-family:Georgia,serif;
        font-weight:700;
      ">
        Engineered for accelerated recovery
      </h2>

      <p style="
        color:#68727d;
        font-size:18px;
        line-height:1.9;
        max-width:560px;
        margin:0 0 34px;
      ">
        Targeted peptide formulations support tissue remodeling,
        modulate inflammation, and accelerate the body's natural
        repair cycle — validated at every batch.
      </p>

      <div style="
        width:100%;
        max-width:420px;
        height:1px;
        background:#d9dee3;
        margin-bottom:30px;
      "></div>

      <!-- STATS -->
      <div style="
        display:flex;
        gap:70px;
        margin-bottom:26px;
      ">

        <div>
          <div style="
            color:#005d6d;
            font-size:52px;
            line-height:1;
            font-family:Georgia,serif;
          ">
            99.2%
          </div>

          <div style="
            margin-top:10px;
            color:#7b8794;
            font-size:11px;
            font-weight:700;
            letter-spacing:1px;
            text-transform:uppercase;
          ">
            Median Purity
          </div>
        </div>

        <div>
          <div style="
            color:#005d6d;
            font-size:52px;
            line-height:1;
            font-family:Georgia,serif;
          ">
            &lt;48h
          </div>

          <div style="
            margin-top:10px;
            color:#7b8794;
            font-size:11px;
            font-weight:700;
            letter-spacing:1px;
            text-transform:uppercase;
          ">
            Dispatch
          </div>
        </div>

      </div>

      <a href="#" style="
        color:#00788b;
        text-decoration:none;
        text-transform:uppercase;
        font-size:13px;
        font-weight:700;
        letter-spacing:1px;
      ">
        Explore The Line →
      </a>

    </div>

  </div>


  <!-- ROW 2: TEXT LEFT / IMAGE RIGHT -->
  <div class="science-row second-row" style="
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:80px;
    align-items:center;
  ">


    <!-- TEXT -->
    <div>

      <span style="
        color:#00788b;
        font-size:11px;
        font-weight:700;
        letter-spacing:3px;
        text-transform:uppercase;
        display:block;
        margin-bottom:16px;
      ">
        Cellular Wellness
      </span>

      <h2 style="
        font-size:58px;
        line-height:1.05;
        color:#051220;
        margin:0 0 24px;
        font-family:Georgia,serif;
        font-weight:700;
      ">
        Optimization at the mitochondrial level
      </h2>

      <p style="
        color:#68727d;
        font-size:18px;
        line-height:1.9;
        max-width:560px;
        margin:0 0 34px;
      ">
        NAD+ and longevity compounds engineered to clinical
        specifications — supporting cellular energy production,
        DNA repair, and metabolic resilience.
      </p>

      <div style="
        width:100%;
        max-width:420px;
        height:1px;
        background:#d9dee3;
        margin-bottom:30px;
      "></div>

      <!-- STATS -->
      <div style="
        display:flex;
        gap:70px;
        margin-bottom:26px;
      ">

        <div>
          <div style="
            color:#005d6d;
            font-size:52px;
            line-height:1;
            font-family:Georgia,serif;
          ">
            ISO
          </div>

          <div style="
            margin-top:10px;
            color:#7b8794;
            font-size:11px;
            font-weight:700;
            letter-spacing:1px;
            text-transform:uppercase;
          ">
            Aligned Facility
          </div>
        </div>

        <div>
          <div style="
            color:#005d6d;
            font-size:52px;
            line-height:1;
            font-family:Georgia,serif;
          ">
            100%
          </div>

          <div style="
            margin-top:10px;
            color:#7b8794;
            font-size:11px;
            font-weight:700;
            letter-spacing:1px;
            text-transform:uppercase;
          ">
            Lot Tested
          </div>
        </div>

      </div>

      <a href="#" style="
        color:#00788b;
        text-decoration:none;
        text-transform:uppercase;
        font-size:13px;
        font-weight:700;
        letter-spacing:1px;
      ">
        Explore The Line →
      </a>

    </div>


    <!-- IMAGE -->
    <!--<div style="-->

    <!--">-->

    <!--  <img -->
    <!--    src="https://syntheratherapeutics.com/wp-content/uploads/2026/09/image-50.png"-->
    <!--    alt="Cellular Wellness"-->
    <!--    style="-->
    <!--      width:100%;-->
    <!--      height:378px;-->
    <!--      object-fit:cover;-->
    <!--      display:block;-->
    <!--    "-->
    <!--  >-->

      <!-- LABEL -->
    <!--  <div style="-->
    <!--    position:absolute;-->
    <!--    left:16px;-->
    <!--    right:16px;-->
    <!--    bottom:18px;-->
    <!--    border:1px solid rgba(255,255,255,.15);-->
    <!--    background:rgba(255,255,255,.06);-->
    <!--    padding:14px 18px;-->
    <!--    color:#d7e7ea;-->
    <!--    font-size:11px;-->
    <!--    letter-spacing:2px;-->
    <!--    text-transform:uppercase;-->
    <!--    font-weight:600;-->
    <!--  ">-->
    <!--    ● LOT CERTIFIED-->
    <!--  </div>-->

    <!--</div>-->

  </div>

</div>


<!-- RESPONSIVE -->
<style>

@media (max-width: 768px) {

  .science-row {
    grid-template-columns: 1fr !important;
    gap: 40px !important;
    margin-bottom: 60px !important;
  }

  .science-row > div {
    width: 100%;
  }

  .science-row h2 {
    font-size: 40px !important;
  }

  .science-row p {
    font-size: 16px !important;
  }

  .science-row img {
    height: 320px !important;
  }

}

</style>

</section>

<style>
@media(max-width:991px){

  .science-row{
    grid-template-columns:1fr !important;
    gap:45px !important;
  }

  .second-row .content{
    order:2;
  }

}

@media(max-width:768px){

  section h2{
    font-size:40px !important;
  }

  .science-row{
    gap:35px !important;
    margin-bottom:60px !important;
  }

}
</style>

<section class="testimonial-section">

  <div class="testimonial-container">

    <!-- HEADING -->
    <div class="testimonial-heading">

      <span>CUSTOMER VOICES</span>

      <h2>Trusted by professionals</h2>

    </div>

    <!-- GRID -->
    <div class="testimonial-grid">

      <!-- CARD -->
      <div class="testimonial-card">

        <div class="stars">
          ★ ★ ★ ★ ★
        </div>

        <p class="testimonial-text">
          "The COA matched stated purity to the decimal. This is the standard I want to see across the industry."
        </p>

        <div class="testimonial-footer">

          <h4>Dr. K. Whitlock</h4>

          <span>SPORTS MEDICINE</span>

        </div>

      </div>

      <!-- CARD -->
      <div class="testimonial-card">

        <div class="stars">
          ★ ★ ★ ★ ★
        </div>

        <p class="testimonial-text">
          "Consistent results across multiple lots. Packaging, fulfillment, and support are all polished."
        </p>

        <div class="testimonial-footer">

          <h4>Marcus T.</h4>

          <span>RESEARCHER</span>

        </div>

      </div>

      <!-- CARD -->
      <div class="testimonial-card">

        <div class="stars">
          ★ ★ ★ ★ ★
        </div>

        <p class="testimonial-text">
          "I recommend Synthera to every one of my high-performing clients. The quality is in another league."
        </p>

        <div class="testimonial-footer">

          <h4>Lena P.</h4>

          <span>WELLNESS COACH</span>

        </div>

      </div>

    </div>

  </div>

</section>

<!-- FAQ SECTION -->
<section class="faq-section">

  <div class="faq-container">

    <!-- LEFT CONTENT -->
    <div class="faq-left">

      <span class="faq-label">FAQ</span>

      <h2>
        Questions,<br>
        answered
      </h2>

      <p>
        Don't see what you're looking for?
        Reach out to our concierge team —
        we typically reply within a few hours.
      </p>

      <a href="#" class="faq-contact-btn">
        CONTACT SUPPORT
        <span>→</span>
      </a>

    </div>

    <!-- RIGHT ACCORDION -->
    <div class="faq-right">

      <div class="faq-item active">
        <button class="faq-question">
          What are peptides?
          <span>−</span>
        </button>

        <div class="faq-answer">
          Peptides are short chains of amino acids used in research
          and wellness applications to support various biological functions.
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          Are your products lab tested?
          <span>+</span>
        </button>

        <div class="faq-answer">
          Yes. Every batch is third-party tested for purity and quality assurance.
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          How long does shipping take?
          <span>+</span>
        </button>

        <div class="faq-answer">
          Orders are typically dispatched within 24–48 hours.
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          Is my payment secure?
          <span>+</span>
        </button>

        <div class="faq-answer">
          All payments are processed securely with encrypted checkout systems.
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          What is your refund policy?
          <span>+</span>
        </button>

        <div class="faq-answer">
          Please contact support for refund eligibility and order review.
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          How should I store products?
          <span>+</span>
        </button>

        <div class="faq-answer">
          Store products in a cool, dry place away from sunlight.
        </div>
      </div>

    </div>

  </div>

</section>

<section style="padding:110px 20px;background:#f4f5f6;font-family:'Inter',sans-serif;">

  <div style="max-width:1180px;margin:0 auto;">

  <!-- TOP -->
  <div style="
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
    margin-bottom:50px;
    gap:20px;
    flex-wrap:wrap;
  ">

    <div>

      <span style="
        color:#00788b;
        font-size:11px;
        font-weight:700;
        letter-spacing:3px;
        text-transform:uppercase;
        display:block;
        margin-bottom:16px;
      ">
        Science Journal
      </span>

      <h2 style="
        font-size:62px;
        line-height:1.05;
        color:#041220;
        margin:0;
        font-family:'Georgia',serif;
        font-weight:700;
      ">
        Insights from the lab
      </h2>

    </div>

    <a href="#" style="
      color:#00788b;
      text-decoration:none;
      font-size:13px;
      font-weight:700;
      letter-spacing:1px;
      text-transform:uppercase;
    ">
      All Articles →
    </a>

  </div>


  <!-- GRID -->
  <div class="journal-grid" style="
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:28px;
  ">


    <!-- CARD 1 -->
    <div style="
      background:#fff;
      border:1px solid #d7dde2;
    ">

      <!-- IMAGE -->
      <div style="
        height:250px;
        position:relative;
        overflow:hidden;
      ">

        <img
          src="https://syntheratherapeutics.com/wp-content/uploads/2026/09/image-51.png"
          alt="What Are Peptides"
          style="
            width:100%;
            height:100%;
            object-fit:cover;
            display:block;
          "
        >

        <!-- BADGE -->
        <span style="
          position:absolute;
          top:14px;
          left:14px;
          background:#f3f4f6;
          color:#00131d;
          font-size:10px;
          font-weight:700;
          letter-spacing:1px;
          padding:6px 10px;
          text-transform:uppercase;
        ">
          Peptides 101
        </span>

      </div>


      <!-- CONTENT -->
      <div style="padding:26px 24px;">

        <h3 style="
          margin:0 0 18px;
          font-size:34px;
          line-height:1.25;
          color:#061321;
          font-family:'Georgia',serif;
          font-weight:500;
        ">
          What Are Peptides? A Researcher's Primer
        </h3>

        <p style="
          margin:0 0 26px;
          color:#66727d;
          font-size:15px;
          line-height:1.8;
        ">
          Short chains of amino acids that orchestrate cellular
          signaling, repair, and regeneration.
        </p>

        <a href="#" style="
          color:#00788b;
          text-decoration:none;
          text-transform:uppercase;
          font-size:12px;
          font-weight:700;
          letter-spacing:1px;
        ">
          Read More →
        </a>

      </div>

    </div>


    <!-- CARD 2 -->
    <div style="
      background:#fff;
      border:1px solid #d7dde2;
    ">

      <!-- IMAGE -->
      <div style="
        height:250px;
        position:relative;
        overflow:hidden;
      ">

        <img
          src="https://syntheratherapeutics.com/wp-content/uploads/2026/09/image-53-scaled.png"
          alt="Accelerated Recovery Science"
          style="
            width:100%;
            height:100%;
            object-fit:cover;
            display:block;
          "
        >

        <!-- BADGE -->
        <span style="
          position:absolute;
          top:14px;
          left:14px;
          background:#f3f4f6;
          color:#00131d;
          font-size:10px;
          font-weight:700;
          letter-spacing:1px;
          padding:6px 10px;
          text-transform:uppercase;
        ">
          Recovery
        </span>

      </div>


      <!-- CONTENT -->
      <div style="padding:26px 24px;">

        <h3 style="
          margin:0 0 18px;
          font-size:34px;
          line-height:1.25;
          color:#061321;
          font-family:'Georgia',serif;
          font-weight:500;
        ">
          The Science of Accelerated Recovery
        </h3>

        <p style="
          margin:0 0 26px;
          color:#66727d;
          font-size:15px;
          line-height:1.8;
        ">
          How targeted compounds modulate inflammation and
          tissue remodeling at the cellular level.
        </p>

        <a href="#" style="
          color:#00788b;
          text-decoration:none;
          text-transform:uppercase;
          font-size:12px;
          font-weight:700;
          letter-spacing:1px;
        ">
          Read More →
        </a>

      </div>

    </div>


    <!-- CARD 3 -->
    <div style="
      background:#fff;
      border:1px solid #d7dde2;
    ">

      <!-- IMAGE -->
      <div style="
        height:250px;
        position:relative;
        overflow:hidden;
      ">

        <img
          src="https://syntheratherapeutics.com/wp-content/uploads/2026/09/image-52.png"
          alt="NAD Plus Cellular Health"
          style="
            width:100%;
            height:100%;
            object-fit:cover;
            display:block;
          "
        >

        <!-- BADGE -->
        <span style="
          position:absolute;
          top:14px;
          left:14px;
          background:#f3f4f6;
          color:#00131d;
          font-size:10px;
          font-weight:700;
          letter-spacing:1px;
          padding:6px 10px;
          text-transform:uppercase;
        ">
          Longevity
        </span>

      </div>


      <!-- CONTENT -->
      <div style="padding:26px 24px;">

        <h3 style="
          margin:0 0 18px;
          font-size:34px;
          line-height:1.25;
          color:#061321;
          font-family:'Georgia',serif;
          font-weight:500;
        ">
          NAD+ and Cellular Health
        </h3>

        <p style="
          margin:0 0 26px;
          color:#66727d;
          font-size:15px;
          line-height:1.8;
        ">
          Inside the coenzyme driving mitochondrial function —
          and why levels decline with age.
        </p>

        <a href="#" style="
          color:#00788b;
          text-decoration:none;
          text-transform:uppercase;
          font-size:12px;
          font-weight:700;
          letter-spacing:1px;
        ">
          Read More →
        </a>

      </div>

    </div>

  </div>

</div>


<!-- RESPONSIVE -->
<style>

@media (max-width: 900px) {

  .journal-grid {
    grid-template-columns:repeat(2,1fr) !important;
  }

}

@media (max-width: 600px) {

  .journal-grid {
    grid-template-columns:1fr !important;
  }

  .journal-grid h3 {
    font-size:28px !important;
  }

  .journal-grid img {
    height:250px !important;
  }

  h2 {
    font-size:44px !important;
  }

}

</style>

</section>

<style>
@media(max-width:991px){

  .journal-grid{
    grid-template-columns:1fr !important;
  }

}

@media(max-width:768px){

  section h2{
    font-size:42px !important;
  }

}
</style>

<!-- =========================
SECTION 1 : NEWSLETTER CTA
========================= -->

<section class="science-newsletter">

  <div class="science-overlay"></div>

  <div class="science-newsletter-inner">

    <div class="newsletter-pill">
      ✉ NEWSLETTER
    </div>

    <h2>
      Stay Ahead of <span>Science.</span>
    </h2>

    <p>
      Exclusive research insights, new product launches, and members-only
      promotions — straight to your inbox.
    </p>

    <form class="science-form">

      <input type="email" placeholder="you@email.com">

      <button type="submit">
        SUBSCRIBE
      </button>

    </form>

    <small>
      No spam. Unsubscribe anytime.
    </small>

  </div>

</section>



<!-- =========================
SECTION 2 : SOCIAL GALLERY
========================= -->

<section class="lab-social-section">

  <div class="lab-social-container">

    <span class="lab-social-label">
      @SYNTHERATHERAPEUTICS
    </span>

    <h2>
      Follow the lab
    </h2>

    <p>
      A look inside our facilities, product launches, and science explainers.
    </p>

    <div class="lab-gallery">

      <a href="#" class="gallery-item">
        <img src="https://images.unsplash.com/photo-1579165466741-7f35e4755660?q=80&w=1200&auto=format&fit=crop" alt="">
      </a>

      <a href="#" class="gallery-item">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/image/image (38).png" alt="img38">

      <a href="#" class="gallery-item">
        <img src="https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?q=80&w=1200&auto=format&fit=crop" alt="">
      </a>

      <a href="#" class="gallery-item">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/image/image (46).png" alt="">
      </a>

      <a href="#" class="gallery-item">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/image/image (37).png" alt="">
      </a>

      <a href="#" class="gallery-item">
        <img src="https://images.unsplash.com/photo-1581595219315-a187dd40c322?q=80&w=1200&auto=format&fit=crop" alt="">
      </a>

    </div>

  </div>

</section>



<style>

/* =========================
GLOBAL
========================= */

.science-newsletter,
.lab-social-section{
    font-family: Inter, sans-serif;
}


/* =========================
NEWSLETTER SECTION
========================= */

.science-newsletter{
    position:relative;
    overflow:hidden;
    padding:110px 20px;
    background:
    radial-gradient(circle at center,
    rgba(0,180,190,.28),
    rgba(0,0,0,0) 38%),
    linear-gradient(90deg,#02131d 0%,#031722 50%,#02131d 100%);
}

.science-overlay{
    position:absolute;
    inset:0;
    background-image:radial-gradient(rgba(0,255,255,.12) 1px,transparent 1px);
    background-size:22px 22px;
    opacity:.18;
}

.science-newsletter-inner{
    max-width:760px;
    margin:0 auto;
    position:relative;
    z-index:2;
    text-align:center;
}

.newsletter-pill{
    display:inline-flex;
    align-items:center;
    gap:8px;
    border:1px solid rgba(0,255,255,.35);
    color:#00d2df;
    padding:9px 18px;
    border-radius:50px;
    font-size:11px;
    letter-spacing:2px;
    font-weight:700;
    margin-bottom:28px;
}

.science-newsletter h2{
    color:#fff;
    font-size:64px;
    line-height:1;
    margin:0 0 22px;
    font-family:Georgia,serif;
    font-weight:700;
}

.science-newsletter h2 span{
    color:#00c6d4;
}

.science-newsletter p{
    max-width:700px;
    margin:0 auto 36px;
    color:#d2d7dc;
    font-size:18px;
    line-height:1.8;
}

.science-form{
    display:flex;
    justify-content:center;
    gap:0;
    max-width:520px;
    margin:0 auto 18px;
}

.science-form input{
    flex:1;
    height:62px;
    border:none;
    padding:0 22px;
    background:rgba(255,255,255,.08);
    color:#fff;
    border:1px solid rgba(255,255,255,.1);
    font-size:15px;
    outline:none;
}

.science-form input::placeholder{
    color:#9ca3af;
}

.science-form button{
    border:none;
    padding:0 34px;
    background:linear-gradient(90deg,#0096a6,#00d7e2);
    color:#fff;
    font-size:13px;
    font-weight:700;
    letter-spacing:1px;
    cursor:pointer;
}

.science-newsletter small{
    color:#7b8792;
    font-size:12px;
}


/* =========================
SOCIAL SECTION
========================= */

.lab-social-section{
    background:#f3f4f6;
    padding:110px 20px;
}

.lab-social-container{
    max-width:1300px;
    margin:0 auto;
    text-align:center;
}

.lab-social-label{
    display:block;
    color:#007b8a;
    font-size:12px;
    font-weight:700;
    letter-spacing:4px;
    margin-bottom:20px;
}

.lab-social-section h2{
    font-size:60px;
    color:#071827;
    margin:0 0 18px;
    font-family:Georgia,serif;
    font-weight:700;
}

.lab-social-section p{
    max-width:760px;
    margin:0 auto 60px;
    color:#6b7280;
    font-size:18px;
    line-height:1.8;
}

.lab-gallery{
    display:grid;
    grid-template-columns:repeat(6,1fr);
    gap:18px;
}

.gallery-item{
    position:relative;
    overflow:hidden;
    display:block;
    aspect-ratio:1/1;
    background:#d1d5db;
}

.gallery-item img{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:.45s ease;
}

.gallery-item:hover img{
    transform:scale(1.08);
}


/* =========================
RESPONSIVE
========================= */

@media(max-width:1100px){

    .lab-gallery{
        grid-template-columns:repeat(3,1fr);
    }

}

@media(max-width:768px){

    .science-newsletter{
        padding:80px 20px;
    }

    .science-newsletter h2{
        font-size:42px;
    }

    .science-newsletter p{
        font-size:16px;
    }

    .science-form{
        flex-direction:column;
    }

    .science-form button{
        height:56px;
    }

    .lab-social-section{
        padding:80px 20px;
    }

    .lab-social-section h2{
        font-size:40px;
    }

    .lab-gallery{
        grid-template-columns:repeat(2,1fr);
    }

}

@media(max-width:480px){

    .lab-gallery{
        grid-template-columns:1fr;
    }

}

</style>

<!-- CTA SECTION -->
<section class="cta-section">

  <div class="cta-container">

    <div class="cta-content">

      <h2>Quality you can verify.</h2>

      <p>
        Every Synthera product ships with its certificate of analysis.
        Order today, dispatched within 48 hours.
      </p>

    </div>

    <div class="cta-action">
      <a href="#" class="cta-btn">
        SHOP THE CATALOG
      </a>
    </div>

  </div>

</section>
<?php
get_footer();
?>