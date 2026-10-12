



<!-- HERO -->
<div class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="badge">🚀 Join 50,000+ sellers</span>
      <h1>Turn your products into a <em>growing business</em></h1>
      <p>List your products, reach millions of customers and get paid on time. We handle payments, shipping and support so you can focus on selling.</p>
      <div class="hero-actions">
        <a href="#signup" class="btn btn-primary">Register as a seller</a>
        <a href="#how" class="btn btn-ghost">See how it works</a>
      </div>
      <div class="hero-note">✓ No setup fee &nbsp; ✓ Free to list &nbsp; ✓ Payments every 7 days</div>
    </div>

    


<div class="hero-card" id="signup">

    <h3>Create your seller account</h3>
    <p>Join Ajobmart and start selling online.</p>

    <div id="sellerSignupMessage"></div>

    <form id="sellerSignupForm"
          
          method="post">


        <div class="field">
            <label for="owner_name">Full name</label>
            <input type="text"
                   id="owner_name"
                   name="owner_name"
                   maxlength="120"
                   value="<?= esc(old('owner_name') ?? '') ?>"
                   placeholder="Your full name"
                   required>
        </div>

        <div class="field">
            <label for="email">Email address</label>
            <input type="email"
                   id="email"
                   name="email"
                   maxlength="190"
                   value="<?= esc(old('email') ?? '') ?>"
                   placeholder="you@example.com"
                   required>
        </div>

        <div class="field">
            <label for="phone">Mobile number</label>
            <input type="tel"
                   id="phone"
                   name="phone"
                   maxlength="25"
                   placeholder="+91 98765 43210"
                   required>
        </div>

        <div class="field">
            <label for="password">Create password</label>
            <input type="password"
                   id="password"
                   name="password"
                   minlength="8"
                   maxlength="72"
                   autocomplete="new-password"
                   required>
        </div>

        <div class="field">
            <label for="confirm_password">Confirm password</label>
            <input type="password"
                   id="confirm_password"
                   name="confirm_password"
                   minlength="8"
                   maxlength="72"
                   autocomplete="new-password"
                   required>
        </div>

        <button class="btn btn-primary w-100"
                type="submit"
                id="sellerSignupBtn">
            Send Email OTP
        </button>

    </form>
</div>


  </div>
</div>

<!-- STATS -->
<section class="stats">
  <div class="wrap stats-grid">
    <div class="stat"><b>50K+</b><span>Active sellers</span></div>
    <div class="stat"><b>2M+</b><span>Monthly customers</span></div>
    <div class="stat"><b>19,000+</b><span>Pin codes served</span></div>
    <div class="stat"><b>7 days</b><span>Payment cycle</span></div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section id="how">
  <div class="wrap center">
    <h2>Start selling in 4 easy steps</h2>
    <p class="sub">From registration to your first order in as little as 24 hours.</p>
    <div class="steps" style="text-align:left">
      <div class="step"><div class="num">1</div><h3>Register</h3><p>Sign up with your email, mobile number and GST / business details.</p></div>
      <div class="step"><div class="num">2</div><h3>List products</h3><p>Add products one by one or upload hundreds at once with our bulk tool.</p></div>
      <div class="step"><div class="num">3</div><h3>Get orders</h3><p>Customers find your products. You get notified instantly for every order.</p></div>
      <div class="step"><div class="num">4</div><h3>Ship &amp; get paid</h3><p>Pack the order, we pick it up, and your payment lands in your bank.</p></div>
    </div>
  </div>
</section>

<!-- BENEFITS -->
<section class="benefits" id="benefits">
  <div class="wrap center">
    <h2>Why sell with Marketly?</h2>
    <p class="sub">Everything you need to run and grow your online store.</p>
    <div class="ben-grid" style="text-align:left">
      <div class="ben"><div class="ico">🌍</div><h3>Huge customer reach</h3><p>Get discovered by millions of shoppers across the country.</p></div>
      <div class="ben"><div class="ico">🚚</div><h3>Easy shipping</h3><p>Discounted courier rates, doorstep pickup and live tracking.</p></div>
      <div class="ben"><div class="ico">💳</div><h3>Secure, fast payments</h3><p>Transparent settlements directly to your bank account.</p></div>
      <div class="ben"><div class="ico">📈</div><h3>Growth tools</h3><p>Ads, promotions and insights to boost your sales.</p></div>
      <div class="ben"><div class="ico">🎧</div><h3>Seller support</h3><p>Dedicated account manager and 24×7 help centre.</p></div>
      <div class="ben"><div class="ico">🎓</div><h3>Free training</h3><p>Learn cataloguing, pricing and marketing at Seller University.</p></div>
    </div>
  </div>
</section>

<!-- CATEGORIES -->
<section>
  <div class="wrap center">
    <h2>Popular categories to sell in</h2>
    <p class="sub">Whatever you make or source, there's a place for it.</p>
    <div class="cats">
      <a href="#" class="cat"><div>👗</div>Fashion</a>
      <a href="#" class="cat"><div>📱</div>Electronics</a>
      <a href="#" class="cat"><div>🏠</div>Home</a>
      <a href="#" class="cat"><div>💄</div>Beauty</a>
      <a href="#" class="cat"><div>🧸</div>Toys</a>
      <a href="#" class="cat"><div>🛒</div>Grocery</a>
    </div>
  </div>
</section>

<!-- PRICING -->
<!-- <section id="pricing" style="background:var(--soft)">
  <div class="wrap center">
    <h2>Simple, transparent pricing</h2>
    <p class="sub">No hidden charges. Pick the plan that fits your business size.</p>
    <div class="price-grid" style="text-align:left">
      <div class="plan"><h3>Starter</h3><div class="amt">₹0 <small>/ month</small></div>
        <ul><li>Up to 50 products</li><li>Basic analytics</li><li>Email support</li></ul>
        <a href="#signup" class="btn btn-ghost" style="text-align:center">Choose Starter</a></div>
      <div class="plan pop"><h3>Growth</h3><div class="amt">₹499 <small>/ month</small></div>
        <ul><li>Unlimited products</li><li>Promotions &amp; ads credit</li><li>Priority support</li><li>Bulk upload tools</li></ul>
        <a href="#signup" class="btn btn-primary" style="text-align:center">Choose Growth</a></div>
      <div class="plan"><h3>Enterprise</h3><div class="amt">Custom</div>
        <ul><li>Dedicated account manager</li><li>API access</li><li>Custom reports</li></ul>
        <a href="#" class="btn btn-ghost" style="text-align:center">Contact sales</a></div>
    </div>
  </div>
</section> -->

<!-- TESTIMONIALS -->
<section id="stories">
  <div class="wrap center">
    <h2>Sellers like you, growing fast</h2>
    <p class="sub">Real stories from sellers on our platform.</p>
    <div class="tgrid" style="text-align:left">
      <div class="quote"><p>“I started from my home with 10 products. Now I ship over 300 orders a month.”</p><div class="who"><div class="av">AS</div><div>Anita S.<span>Handloom seller</span></div></div></div>
      <div class="quote"><p>“Payments are on time and the support team solves issues quickly.”</p><div class="who"><div class="av">RK</div><div>Rahul K.<span>Electronics seller</span></div></div></div>
      <div class="quote"><p>“The bulk upload saved me days of work. Highly recommended.”</p><div class="who"><div class="av">MP</div><div>Meera P.<span>Home décor seller</span></div></div></div>
    </div>
  </div>
</section>

<!-- FAQ -->
<section id="faq" style="padding-top:0">
  <div class="wrap">
    <div class="center"><h2>Frequently asked questions</h2><p class="sub">Quick answers before you get started.</p></div>
    <div class="faq">
      <details open><summary>What documents do I need to register?</summary><p>A PAN card, bank account details and, if applicable, a GST number. Some categories may need extra approvals.</p></details>
      <details><summary>How much does it cost to sell?</summary><p>Listing is free. A small commission and shipping fee apply per order, depending on the category.</p></details>
      <details><summary>When will I receive my payment?</summary><p>Payments are settled to your bank account every 7 days after delivery.</p></details>
      <details><summary>Who handles shipping and returns?</summary><p>Our logistics partners pick up from your address and manage delivery and returns.</p></details>
    </div>
  </div>
</section>

<!-- FINAL CTA -->
<div class="wrap">
  <div class="cta">
    <h2>Ready to grow your business?</h2>
    <p>Create your seller account in minutes. It's free to get started.</p>
    <a href="#signup" class="btn">Start selling today</a>
  </div>
</div>






