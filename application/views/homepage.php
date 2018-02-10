<?php
    $all_posts = $this->app->cdata("all_posts");
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Clean Blog - Start Bootstrap Theme</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>assets/css/clean-blog.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/header.css" rel="stylesheet">

    
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand" href="#">Start Bootstrap</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url(); ?>aboutus">About</a>
            </li>
            <?php if(!isset($_SESSION["user_data"])): ?>
            <li class="nav-item">
              <a class="nav-link" data-toggle="modal" data-target="#login">Log In</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url(); ?>profile">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url(); ?>logout">Log out</a>
            </li>
          <?php endif; ?>

          </ul>
        </div>
      </div>
    </nav>

    <!-- Modal -->
    <div id="login" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
            
            <form action="<?php echo base_url(); ?>" method="POST">
              <div class="form-group">
                <label for="username">User Name:</label>
                <input type="text" class="form-control" id="username" name="username" value="">
              </div>
              <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="text" class="form-control" id="pwd" name="password" value="">
              </div>
              <a href="<?php echo base_url(); ?>signup">Need Account?</a><br>
              <button type="submit" class="btn btn-default" name="login">Sign In</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </form>


          </div>
        </div>

      </div>
    </div>
    
    

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('img/home-bg.jpg')">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
              <h1>Clean Blog</h1>
              <span class="subheading">A Blog Theme by Start Bootstrap</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <?php if(isset($_SESSION["user_data"])): ?>
            <div class="col-lg-12 col-md-12 mx-auto">
                <button class="btn btn-danger"  data-toggle="modal" data-target="#addPost">Add Posts</button>
              
            </div>  
          <?php endif; ?>
        

        <div class="col-lg-8 col-md-10 mx-auto">
          <?php if($all_posts): ?>
            <?php foreach ($all_posts as $key => $all_post): ?>
              <div class="post-preview">
                <a href="<?php echo base_url().'post/'.$all_post->post_id; ?>">
                  <h2 class="post-title">
                    <?php echo $all_post->title; ?>
                  </h2>
                  <h3 class="post-subtitle">
                    <?php echo $all_post->post_text; ?>
                  </h3>
                </a>
                <p class="post-meta">Posted by
                  <a href="#"><?php echo $all_post->username; ?></a>
                  on <?php echo  date("M d, Y H:i A", strtotime($all_post->date)); ?></p>
              </div>
              <hr>
            <?php endforeach; ?>
          <?php endif; ?>
          <!-- Pager -->
          <div class="clearfix">
            <!-- <a class="btn btn-primary float-right" href="#">Older Posts &rarr;</a> -->
          </div>
        </div>
      </div>
    </div>

    <hr>

     <!-- Modal -->
    <div id="addPost" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
            
            <form action="<?php echo base_url(); ?>" method="POST">
              <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="">
              </div>
              <div class="form-group">
                <label for="context">Description</label>
                <textarea row="10" class="form-control" id="context" name="post_text"></textarea>
              </div>
              <button type="submit" class="btn btn-default" name="submit">Add</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </form>


          </div>
        </div>

      </div>
    </div>
    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <ul class="list-inline text-center">
              <li class="list-inline-item">
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
            </ul>
            <p class="copyright text-muted">Copyright &copy; Your Website 2018</p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="<?php //echo base_url(); ?>assets/js/clean-blog.min.js"></script>

  </body>
       
</html>
