<h1 class="mb-3">Member Login</h1>
<form method="post" action="/highstreetgym/controllers/authcontroller.php" class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Login</button>
  </div>
</form>