<?php
/**
 * Template Name: Journal Page
 * The front page template for WordPress
 */
get_header()
?>
<style>
    /* =========================
   JOURNAL SECTION
========================= */

.journal-section{
  background:#f5f5f5;
  padding:110px 0 120px;
}

/* HEADER */

.journal-header{
  width:90%;
  max-width:1250px;
  margin:0 auto 70px;
}

.journal-tag{
  display:inline-block;

  color:#009bb0;

  font-size:12px;
  letter-spacing:6px;
  text-transform:uppercase;

  margin-bottom:18px;
}

.journal-header h2{
  font-size:78px;
  line-height:1.05;

  margin:0 0 22px;

  color:#07111c;

  font-family: Georgia, serif;
  font-weight:700;
}

.journal-header p{
  font-size:22px;
  line-height:1.8;

  color:#5e6772;

  max-width:820px;
}

/* GRID */

.journal-grid{
  width:90%;
  max-width:1250px;

  margin:auto;

  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:32px;
}

/* CARD */

.journal-card{
  background:#fff;
  border:1px solid #dddddd;

  transition:0.35s ease;

  overflow:hidden;
}

.journal-card:hover{
  transform:translateY(-6px);
  box-shadow:0 15px 40px rgba(0,0,0,0.08);
}

/* IMAGE */

.journal-image{
  width:100%;
  height:360px;
  overflow:hidden;
}

.journal-image img{
  width:100%;
  height:100%;
  object-fit:cover;

  transition:0.5s ease;
}

.journal-card:hover img{
  transform:scale(1.05);
}

/* CONTENT */

.journal-content{
  padding:34px 34px 38px;
}

.journal-meta{
  display:block;

  color:#7d8792;

  font-size:13px;
  letter-spacing:1px;

  margin-bottom:18px;
}

.journal-content h3{
  font-size:42px;
  line-height:1.2;

  margin:0 0 22px;

  color:#08111b;

  font-family: Georgia, serif;
  font-weight:700;
}

.journal-content p{
  font-size:17px;
  line-height:1.9;

  color:#5d6770;

  margin-bottom:28px;
}

.journal-content a{
  color:#008fa1;

  text-decoration:none;

  font-size:14px;
  font-weight:700;
  letter-spacing:1px;

  transition:0.3s ease;
}

.journal-content a:hover{
  letter-spacing:2px;
}

/* =========================
   RESPONSIVE
========================= */

@media (max-width:1200px){

  .journal-header h2{
    font-size:60px;
  }

  .journal-content h3{
    font-size:34px;
  }

}

@media (max-width:992px){

  .journal-grid{
    grid-template-columns:repeat(2,1fr);
  }

}

@media (max-width:768px){

  .journal-section{
    padding:80px 0;
  }

  .journal-grid{
    grid-template-columns:1fr;
  }

  .journal-header{
    margin-bottom:50px;
  }

  .journal-header h2{
    font-size:42px;
  }

  .journal-header p{
    font-size:17px;
  }

  .journal-content{
    padding:28px;
  }

  .journal-content h3{
    font-size:28px;
  }

  .journal-image{
    height:280px;
  }

}

@media (max-width:480px){

  .journal-header h2{
    font-size:34px;
  }

  .journal-content h3{
    font-size:24px;
  }

}
</style>
<!-- =========================
     JOURNAL SECTION
========================= -->

<section class="journal-section">

  <!-- TOP -->
  <div class="journal-header">

    <span class="journal-tag">JOURNAL</span>

    <h2>Research notes</h2>

    <p>
      The science, the people, and the protocols behind
      Synthera Therapeutics.
    </p>

  </div>

  <!-- POSTS -->
  <div class="journal-grid">

    <!-- CARD -->
    <article class="journal-card">

      <div class="journal-image">
        <img src="https://images.unsplash.com/photo-1532187643603-ba119ca4109e?q=80&w=1200&auto=format&fit=crop" alt="">
      </div>

      <div class="journal-content">

        <span class="journal-meta">
          MAY 2026 • 6 MIN READ
        </span>

        <h3>
          Peptides 101: A primer for serious researchers
        </h3>

        <p>
          What peptides are, how they're synthesized, and
          what to look for when sourcing them.
        </p>

        <a href="#">
          READ MORE →
        </a>

      </div>

    </article>

    <!-- CARD -->
    <article class="journal-card">

      <div class="journal-image">
        <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=1200&auto=format&fit=crop" alt="">
      </div>

      <div class="journal-content">

        <span class="journal-meta">
          APR 2026 • 8 MIN READ
        </span>

        <h3>
          Why third-party testing is non-negotiable
        </h3>

        <p>
          An inside look at our independent lab partners
          and the assays they run on every batch.
        </p>

        <a href="#">
          READ MORE →
        </a>

      </div>

    </article>

    <!-- CARD -->
    <article class="journal-card">

      <div class="journal-image">
        <img src="https://images.unsplash.com/photo-1532187643603-ba119ca4109e?q=80&w=1200&auto=format&fit=crop" alt="">
      </div>

      <div class="journal-content">

        <span class="journal-meta">
          MAR 2026 • 10 MIN READ
        </span>

        <h3>
          NAD+ and the new science of cellular longevity
        </h3>

        <p>
          How NAD+ supports mitochondrial function and
          what current research suggests.
        </p>

        <a href="#">
          READ MORE →
        </a>

      </div>

    </article>

  </div>

</section>

<?php
get_footer()
?>

