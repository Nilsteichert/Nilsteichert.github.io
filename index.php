<!DOCTYPE html>
<html lang="en">
<head>
  <title>Notetrainer</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap-4.6.0-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>


<body>
    
<?php
  
    include 'create_acc.php';
    
?>

<!-- Load libarys -->
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="js/vexflow-min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/webmidi@2.5.1"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.20/lodash.min.js"></script>

<!-- P5, ml5 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.3/p5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.9.0/addons/p5.dom.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.9.0/addons/p5.sound.min.js"></script>
<script src="https://unpkg.com/ml5@latest/dist/ml5.min.js"></script>

<!-- Load scripts without reference to the document -->
<script src="js/aubio.js"></script>
<script src="js/tuner.js"></script>

<script src="js/note.js"></script>
<script src="js/notedrawer.js"></script>
<script src="js/keysignatures.js"></script>
<script src="js/box-animator.js"></script>
<script src="js/noteChecker.js"></script>
<script src="js/midi-listener.js"></script>
<script src="js/musicapp.js"></script>







    <!--Navbar  -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <a href="/" class="navbar-brand">MusicTrainer</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar7">
      <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-collapse collapse justify-content-stretch" id="navbar7">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="#" data-target="#login-register-form" title="Placeholder link title" data-toggle="modal">
          <i class="bi bi-person-fill"></i>&nbsp;&nbsp;Login
          </a>
      </ul>
  </div>
</nav>
  

<!--Site content  -->

<div class="container-fluid mt-5" >
  <div class=row>
    <div class="mx-auto d-block" id=noteDraw style="background-color: rgb(255,255,255); width:500px;height: 400px; border-radius:4%"> </div>
  </div>
  <div class="row">
    <div class="btn btn-success mx-auto d-block mt-3" role="group" onclick="app.toggleMic()" id="micToggle" href="javascript:void()" >Enable microphone
    </div>  
  </div>    
  <div class="row">
    <div class="btn-group  mx-auto d-block mt-3 dropup" role="group">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonMajor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Major keys
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonMajor">
      <a class="dropdown-item"id="randommajor" href="javascript:void(0)" onclick="app.selectKeySignature('major')">Random</a>
      <a class="dropdown-item"id="C" href="javascript:void(0)" onclick="app.selectKeySignature('C')">C-Major</a>
      <a class="dropdown-item"id="G" href="javascript:void(0)" onclick="app.selectKeySignature('G')">G-Major</a>
      <a class="dropdown-item"id="D" href="javascript:void(0)" onclick="app.selectKeySignature('D')">D-Major</a>
      <a class="dropdown-item"id="A" href="javascript:void(0)" onclick="app.selectKeySignature('A')">A-Major</a>
      <a class="dropdown-item"id="E" href="javascript:void(0)" onclick="app.selectKeySignature('E')">E-Major</a>
      <a class="dropdown-item"id="B" href="javascript:void(0)" onclick="app.selectKeySignature('B')">B-Major</a>
      <a class="dropdown-item"id="F#"href="javascript:void(0)" onclick="app.selectKeySignature('F#')">F♯-Major</a>
      <a class="dropdown-item"id="C#"href="javascript:void(0)" onclick="app.selectKeySignature('C#')">C♯-Major</a>          
      <a class="dropdown-item"id="F" href="javascript:void(0)" onclick="app.selectKeySignature('F')">F-Major</a>
      <a class="dropdown-item"id="Bb"href="javascript:void(0)" onclick="app.selectKeySignature('Bb')">B♭-Major</a>
      <a class="dropdown-item"id="Eb"href="javascript:void(0)" onclick="app.selectKeySignature('Eb')">E♭-Major</a>
      <a class="dropdown-item"id="Ab"href="javascript:void(0)" onclick="app.selectKeySignature('Ab')">A♭-Major</a>
      <a class="dropdown-item"id="Db"href="javascript:void(0)" onclick="app.selectKeySignature('Db')">D♭-Major</a>
      <a class="dropdown-item"id="Gb"href="javascript:void(0)" onclick="app.selectKeySignature('Gb')">G♭-Major</a>
      <a class="dropdown-item"id="Cb"href="javascript:void(0)" onclick="app.selectKeySignature('Cb')">C♭-Major</a> 
    </div>
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonMinor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Minor keys
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonMinor">
        <a class="dropdown-item" id ="randomminor" onclick="selectKeySignature('minor')">Random</a>
        <a class="dropdown-item" id ="Am" href="javascript:void(0)" onclick="selectKeySignature('Am')">A-Minor</a>
        <a class="dropdown-item" id ="Dm" href="javascript:void(0)" onclick="selectKeySignature('Dm')">D-Minor</a>
        <a class="dropdown-item" id ="Gm" href="javascript:void(0)" onclick="selectKeySignature('Gm')">G-Minor</a>
        <a class="dropdown-item" id ="Cm" href="javascript:void(0)" onclick="selectKeySignature('Cm')">C-Minor</a>
        <a class="dropdown-item" id ="Fm" href="javascript:void(0)" onclick="selectKeySignature('Fm')">F-Minor</a>
        <a class="dropdown-item" id ="Bbm" href="javascript:void(0)" onclick="selectKeySignature('Bbm')">B♭-Minor</a>
        <a class="dropdown-item" id ="Ebm" href="javascript:void(0)" onclick="selectKeySignature('Ebm')">E♭-Minor</a>
        <a class="dropdown-item" id ="Abm" href="javascript:void(0)" onclick="selectKeySignature('Abm')">A♭-Minor</a>          
        <a class="dropdown-item" id ="Em" href="javascript:void(0)" onclick="selectKeySignature('Em')">E-Minor</a>
        <a class="dropdown-item" id ="Bm" href="javascript:void(0)" onclick="selectKeySignature('Bm')">B-Minor</a>
        <a class="dropdown-item" id ="F#m" href="javascript:void(0)" onclick="selectKeySignature('F#m')">F♯-Minor</a>
        <a class="dropdown-item" id ="C#m" href="javascript:void(0)" onclick="selectKeySignature('C#m')">C♯-Minor</a>
        <a class="dropdown-item" id ="G#m" href="javascript:void(0)" onclick="selectKeySignature('G#m')">G♯-Minor</a>
        <a class="dropdown-item" id ="D#m" href="javascript:void(0)" onclick="selectKeySignature('D#m')">D♯-Minor</a>
        <a class="dropdown-item" id ="A#m" href="javascript:void(0)" onclick="selectKeySignature('A#m')">A♯-Minor</a>
    </div> 
    </div>

  </div>
</div>



</div>


<!-- Modals -->
<div class="modal" id="settings-modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Settings</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
        <div class="row">
        <div class="col-2">
        
      </div>

      <div class="col-2">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonMinor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Minor keys
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonMinor">
            <a class="dropdown-item" id ="randomminor" onclick="selectKeySignature('minor')">Random</a>
            <a class="dropdown-item" id ="Am" href="javascript:void()" onclick="selectKeySignature('Am')">A-Minor</a>
            <a class="dropdown-item" id ="Dm" href="javascript:void()" onclick="selectKeySignature('Dm')">D-Minor</a>
            <a class="dropdown-item" id ="Gm" href="javascript:void()" onclick="selectKeySignature('Gm')">G-Minor</a>
            <a class="dropdown-item" id ="Cm" href="javascript:void()" onclick="selectKeySignature('Cm')">C-Minor</a>
            <a class="dropdown-item" id ="Fm" href="javascript:void()" onclick="selectKeySignature('Fm')">F-Minor</a>
            <a class="dropdown-item" id ="Bbm" href="javascript:void()" onclick="selectKeySignature('Bbm')">B♭-Minor</a>
            <a class="dropdown-item" id ="Ebm" href="javascript:void()" onclick="selectKeySignature('Ebm')">E♭-Minor</a>
            <a class="dropdown-item" id ="Abm" href="javascript:void()" onclick="selectKeySignature('Abm')">A♭-Minor</a>          
            <a class="dropdown-item" id ="Em" href="javascript:void()" onclick="selectKeySignature('Em')">E-Minor</a>
            <a class="dropdown-item" id ="Bm" href="javascript:void()" onclick="selectKeySignature('Bm')">B-Minor</a>
            <a class="dropdown-item" id ="F#m" href="javascript:void()" onclick="selectKeySignature('F#m')">F♯-Minor</a>
            <a class="dropdown-item" id ="C#m" href="javascript:void()" onclick="selectKeySignature('C#m')">C♯-Minor</a>
            <a class="dropdown-item" id ="G#m" href="javascript:void()" onclick="selectKeySignature('G#m')">G♯-Minor</a>
            <a class="dropdown-item" id ="D#m" href="javascript:void()" onclick="selectKeySignature('D#m')">D♯-Minor</a>
            <a class="dropdown-item" id ="A#m" href="javascript:void()" onclick="selectKeySignature('A#m')">A♯-Minor</a>
        </div> 
      </div>
    </div>
  </div>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> 

<!-- Login -->
<!-- Modal HTML -->
 <!-- Login / Register Modal-->
 <div class="modal fade login-register-form" role="dialog" id="login-register-form">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">
                  <span class="glyphicon glyphicon-remove"></span>
              </button>
              <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#login-form"> Login <span class="glyphicon glyphicon-user"></span></a></li>
                  <li><a data-toggle="tab" href="#registration-form"> Register <span class="glyphicon glyphicon-pencil"></span></a></li>
              </ul>
          </div>
          <div class="modal-body">
              <div class="tab-content">
                  <div id="login-form" class="tab-pane fade in active">
                      <form action="index.php" method="POST">
                          <div class="form-group">
                              <label for="email">Email:</label>
                              <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                          </div>
                          <div class="form-group">
                              <label for="pwd">Password:</label>
                              <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
                          </div>
                          <div class="checkbox">
                              <label><input type="checkbox" name="remember"> Remember me</label>
                          </div>
                          <button type="submit" class="btn btn-default">Login</button>
                      </form>
                  </div>
                  <div id="registration-form" class="tab-pane fade">
                      <form action="index.php" method="POST">
                          <div class="form-group">
                              <label for="name">Your Name:</label>
                              <input type="text" class="form-control" id="name" placeholder="Enter your name" name="name">
                          </div>
                          <div class="form-group">
                              <label for="newemail">Email:</label>
                              <input type="email" class="form-control" id="newemail" placeholder="Enter new email" name="newemail">
                          </div>
                          <div class="form-group">
                              <label for="newpwd">Password:</label>
                              <input type="password" class="form-control" id="newpwd" placeholder="New password" name="newpwd">
                          </div>
                          <button type="submit" class="btn btn-default">Register</button>
                      </form>
                  </div>

              </div>
          </div>
               <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>


<script src="js/init.js"></script>
</body>
</html>

