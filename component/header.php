<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?= isset($meta_title) ? $meta_title : '404' ?></title>
        <meta name="format-detection" content="telephone=no">
        <link rel="icon" type="image/png" href="lib/static/ico.png">
        <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="lib/toast/toast.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <link rel="stylesheet" type="text/css" href="lib/static/all.css">
        <link rel="stylesheet" type="text/css" href="lib/static/media.css">
        <link rel="stylesheet" type="text/css" href="lib/static/css/main.css">
        <link href="lib/fontawesome/css/fontawesome.css" rel="stylesheet">
        <link href="lib/fontawesome/css/solid.css" rel="stylesheet">


        
        <script src="lib/jquery/jquery.js"></script>        
        <script src="lib/popper/popper.min.js"></script>     
        
        <script src="lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="lib/toast/toast.min.js"></script>     
        <script src="lib/static/js/main.js"></script>
        <script src="lib/datatable/js/jquery.dataTables.min.js"></script> 
        <script src="lib/datatable/js/dataTables.bootstrap4.min.js"></script> 
        <script src="lib/js/mema.js"></script>

        <link rel="stylesheet" type="text/css" href="lib/static/master/master.css?v=2">
        <script src="lib/static/master/master.js?v=2"></script>


        
    </head>
    <body class="master">


<div id="confirm-modal" class="modal fade" data-backdrop="static" data-keyboard="false" data-focus="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1200">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <div class="modal-body p-5">

                <div class="card-panel p-4 border-0 mb-0 rounded-0 text-cente" data-dismiss="modal">
                    <div class="icon-lg-pop mb-4 text-center" id="icon_notif">
                        <i style="font-size: 30px" class="fas fa-lg fa-bell"></i>
                    </div>

                    <div class="icon-lg-pop mb-4 text-center" id="icon_remove">
                        <i style="font-size: 30px" class="fas fa-lg fa-bell"></i>
                    </div>
                    <p class="m-0 font-weight-bold text-center" id="confirm-message">Press Yes to continue</p>
                    <div class="pt-4 text-center">
                        <button id="confirm-ok" class="btn" data-callback="true">Ok</button>
                        <button id="confirm-no" class="btn-secondary btn" data-callback="false">Cancel</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="i-loader"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>

<div class="content-header">
	<div class="row">
		<div class="system-name">
			<h1 class="text-white p-4 pl-5" style="letter-spacing: 0.3rem">Online Form Requisitions</h1>
		</div>
		<div class="drawer-btn">
			<button class="btn-bars btn text-white" id="menu_button"><i class="fas fa-lg fa-bars"></i></button> 
		</div>
	</div>
</div>