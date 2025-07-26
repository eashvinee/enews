<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
     <?php wp_head(); ?>
  </head>
<body <?php body_class(); ?>>   
<?php wp_body_open(); ?>
<nav class="navbar navbar-expand-md fixed-top lh-1 py-3 bg-body-tertiary border-bottom">
  <div class="container">
    <a class="navbar-brand" href="<?php echo home_url('/'); ?>">eNews7</a>
    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="navbarCollapse" style="">
      <!--form class="d-flex me-auto" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form-->
      <div class="me-auto"></div>
      <ul class="navbar-nav  mb-2 mb-md-0">
        <li class="nav-item">
          <a class="nav-link active" href="<?php echo home_url('/'); ?>">
            <svg class="bi mx-auto" width="24" height="18"><use xlink:href="#svg-home"></use></svg> 
            Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo home_url('/tag/trending'); ?>">
            <svg class="bi mx-auto" width="24" height="18"><use xlink:href="#svg-tranding"></use></svg> 
            Trending
          </a>
        </li>
        <?php if ( is_user_logged_in() ): ?>
        <li class="nav-item">
          <a href="<?php echo home_url('/wp-admin'); ?>" class="nav-link">
            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
              Dashboard
          </a>
        </li>
        <li class="nav-item">
              <a href="<?php echo wp_logout_url( home_url('/')); ?>"  class="nav-link"><svg class="bi mx-auto" width="24" height="18"><use xlink:href="#people-circle"></use></svg>  Logout</a>
        </li>
         <?php else: ?>
         <li class="nav-item dropdown">
            <a  href="#" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> 
              <svg class="bi mx-auto" width="24" height="18"><use xlink:href="#people-circle"></use></svg> 
              Login
            </a> 
             <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?php echo home_url('/wp-admin'); ?>">Login</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="<?php echo home_url('/wp-login.php?action=register'); ?>">Register</a></li>
            </ul>        
         </li>
         <?php endif; ?>
      </ul>
      
    </div>
  </div>
</nav>