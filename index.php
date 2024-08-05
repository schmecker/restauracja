<?php session_start(); ?>
<?php include "header.php"; ?>	
	<!-- Start slides -->
	<br>
	<div id="slides" class="cover-slides">
		<ul class="slides-container">
			<li class="text-left">
				<img src="img\bg\danie (4).jpg" alt="">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h1 class="m-b-20">Witaj w <br><strong> Blue Shark</strong></h1>
							<p class="m-b-40">Lorem ipsum dolor sit amet,    <br> 
							consectetur adipiscing elit.</p>
							<p><a class="btn btn-lg btn-circle btn-outline-new-white" href="menu.php">Menu</a></p>
						</div>
					</div>
				</div>
			</li>
			<li class="text-left">
				<img src="img\bg\danie (7).jpg" alt="">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h1 class="m-b-20">Lubimy dobrze <br><strong>zjeść</strong></h1>
							<p class="m-b-40">Lorem ipsum dolor sit amet, 
                                <br> 
                            Lorem ipsum dolor sit amet,</p>
							<p><a class="btn btn-lg btn-circle btn-outline-new-white" href="review.php">Opinie</a></p>
						</div>
					</div>
				</div>
			</li>

		</ul>
		<div class="slides-navigation">
			<a href="#" class="next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
			<a href="#" class="prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
		</div>
	</div>
	<!-- End slides -->
	
   <!-- Start About -->
   <div class="about-section-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                    <div class="inner-column">
                        <h1>Witaj w <span>Restauracji</span></h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sit amet malesuada tellus. Maecenas sit amet lacus dignissim, porttitor nunc vitae, venenatis mauris. Vestibulum pellentesque faucibus efficitur. Donec mollis urna
 </p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sit amet malesuada tellus. Maecenas sit amet lacus dignissim, porttitor nunc vitae, venenatis mauris. Vestibulum pellentesque faucibus efficitur. Donec mollis urna</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <img src="img/bg/rest.jpg"  width="200%" height="200%" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <!-- End About -->
    
    <!-- Start QT -->
    <div class="qt-box qt-background">
        <div class="container">
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto text-center">
                    <p class="lead ">
                    Vestibulum pellentesque faucibus efficitur. Donec mollis urna non odio lobortis pretium. Integer eu pretium mi. Nullam eros velit, facilisis                    </p>
                    </div>
            </div>
        </div>
    </div>
    <!-- End QT -->
    
    <!-- Start Menu -->
    <div class="menu-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-title text-center">
                        <h2>Special Menu</h2>
                        <p>Enjoy the new Tasty</p>
                    </div>
                </div>
            </div>
            
            <div class="row inner-menu-box">
                <div class="col-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <?php
                        include "connect.php";
                        $categories = mysqli_query($con, "SELECT DISTINCT catnm FROM food_cat");
                        echo "<button class='nav-link active' data-category='all'>All</button>";
                        while ($cat = mysqli_fetch_array($categories)) {
                            echo "<button class='nav-link' data-category='{$cat['catnm']}'>{$cat['catnm']}</button>";
                        }
                        ?>
                    </div>
                </div>
                
                <div class="col-9">
                <div id="menu-content" class="row">
                    <?php
                    $s = mysqli_query($con, "SELECT * FROM menu");
                    while ($r = mysqli_fetch_array($s)) {
                        echo "
                        <div class='col-lg-4 col-md-6 special-grid drinks'>
                            <div class='business-card'>
                                <div class='image-container'>
                                    <img src='admin/{$r['image']}' class='img-fluid' alt='Image'>
                                </div>
                                <div class='card-content'>
                                    <h4>{$r['title']}</h4>
                                    <p>{$r['description']}</p>
                                    <p>{$r['price']} zł</p>
                                </div>
                                <div class='button-container'>
                                    ";
                                    if (isset($_SESSION['uid'])) {
                                        echo "<button class='btn custom-btn add-to-cart' data-pid='{$r['id']}' data-price='{$r['price']}'>Dodaj do koszyka</button>";
                                    } else {
                                        echo "<a href='login.php' class='btn custom-btn'>Dodaj do koszyka</a>";
                                    }
                        echo "
                                </div>
                            </div>
                        </div>";
                    }
                    ?>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- End Menu -->
    
<!-- Start Customer Reviews -->
<div class="customer-reviews-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading-title text-center">
                <h2>Opinie klientów</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mr-auto ml-auto text-center">
                <div id="reviews" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner mt-4">
                        <?php 
                        include "connect.php";
                        $s = mysqli_query($con,"SELECT * FROM review LIMIT 4");
                        $first = true; // Flaga do ustawiania klasy 'active' tylko dla pierwszego elementu
                        while($r = mysqli_fetch_array($s)) { ?>
                        <div class="carousel-item text-center <?php if($first) { echo 'active'; $first = false; } ?>">
                            <div class="img-box p-1 border rounded-circle m-auto">
                                <img class="d-block w-100 rounded-circle" src="img/bg/quotations-button.png" alt="">
                            </div>
                            <h5 class="mt-4 mb-0"><strong class="text-warning text-uppercase">
                                <?php echo $r['name']; ?>
                            </strong></h5>
                            <h6 class="text-dark m-0">Opinia : <?php echo $r['review']; ?></h6>
                            <p class="m-0 pt-3">
                                <?php echo $r['description']; ?>
                            </p>
                        </div>
                        <?php } ?>
                    </div>
                    <a class="carousel-control-prev" href="#reviews" role="button" data-slide="prev">
                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                        <span class="sr-only">Poprzednia</span>
                    </a>
                    <a class="carousel-control-next" href="#reviews" role="button" data-slide="next">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                        <span class="sr-only">Następna</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Customer Reviews -->
<?php include "footer.php"; ?>
<script>
$(document).ready(function() {
    $('.nav-link').click(function() {
        var category = $(this).data('category');
        
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
        
        $.ajax({
            url: 'get_menu.php',
            method: 'GET',
            data: { category: category },
            success: function(response) {
                $('#menu-content').html(response);
            }
        });
    });
});
</script>
