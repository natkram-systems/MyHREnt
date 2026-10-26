<a href="<?= app_url('careers') ?>" style="color:#64748b;text-decoration:none;font-size:.85rem">← All positions</a>
<div class="card" style="margin-top:1rem">
  <h1 style="font-size:1.5rem;margin:0 0 .5rem">Junior Developer</h1>
  <p style="color:#64748b;margin:0 0 2rem">Engineering · Regular · Open until filled</p>
  <h3 style="font-size:1rem;margin:0 0 .5rem">Description</h3>
  <p style="color:#475569;line-height:1.6">We are seeking a motivated Junior Developer to join our growing engineering team. You will work on internal tools, learn our codebase, and contribute to production software under experienced mentorship.</p>
  <h3 style="font-size:1rem;margin:1.5rem 0 .5rem">Responsibilities</h3>
  <ul style="color:#475569;line-height:1.7">
    <li>Write clean, testable PHP and JavaScript code</li>
    <li>Participate in code reviews and sprint planning</li>
    <li>Debug and fix reported issues</li>
  </ul>
  <h3 style="font-size:1rem;margin:1.5rem 0 .5rem">Qualifications</h3>
  <ul style="color:#475569;line-height:1.7">
    <li>Bachelor's degree in Computer Science or equivalent</li>
    <li>Working knowledge of PHP 8+ and MySQL</li>
    <li>Strong problem-solving and communication skills</li>
  </ul>
</div>
<div class="card" style="margin-top:1.5rem">
  <h3 style="font-size:1rem;margin:0 0 1rem">Apply for this position</h3>
  <form method="post" enctype="multipart/form-data">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem">
      <div><label>First name</label><input type="text" name="first_name" required></div>
      <div><label>Last name</label><input type="text" name="last_name" required></div>
    </div>
    <div style="margin-bottom:1rem"><label>Email</label><input type="email" name="email" required></div>
    <div style="margin-bottom:1rem"><label>Phone</label><input type="tel" name="phone"></div>
    <div style="margin-bottom:1rem"><label>Resume (PDF)</label><input type="file" name="resume" accept=".pdf,.jpg,.png" required></div>
    <div style="margin-bottom:1.5rem"><label>Cover letter (optional)</label><textarea name="cover_letter" rows="4"></textarea></div>
    <button type="submit" class="btn btn-dark">Submit Application</button>
  </form>
</div>