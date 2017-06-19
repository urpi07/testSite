
<div class="nav-side-menu">
    <div class="brand">Brand Logo</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
                <li>
                  <a href="dashboard" class="menulink">
                  <i class="fa fa-dashboard fa-lg"></i> Dashboard
                  </a>
                </li>
                
                 <li>
                  <a href="users" class="menulink">
                  <i class="fa fa-users fa-lg"></i> Loans
                  </a>
                </li>
                
                 <li>
                  <a href="clients" class="menulink">
                  <i class="fa fa-users fa-lg"></i> Clients
                  </a>
                </li>                                
<!--
                <li  data-toggle="collapse" data-target="#products" class="collapsed active">
                  <a href="#"><i class="fa fa-gift fa-lg"></i> UI Elements <span class="arrow"></span></a>
                </li>
                 <ul class="sub-menu collapse" id="products">
                    <li class="active"><a href="#">CSS3 Animation</a></li>
                    <li><a href="#">General</a></li>
                    <li><a href="#">Buttons</a></li>
                    <li><a href="#">Tabs & Accordions</a></li>
                    <li><a href="#">Typography</a></li>
                    <li><a href="#">FontAwesome</a></li>
                    <li><a href="#">Slider</a></li>
                    <li><a href="#">Panels</a></li>
                    <li><a href="#">Widgets</a></li>
                    <li><a href="#">Bootstrap Model</a></li>
                </ul>


                <li data-toggle="collapse" data-target="#service" class="collapsed">
                  <a href="#"><i class="fa fa-globe fa-lg"></i> Services <span class="arrow"></span></a>
                </li>  
                <ul class="sub-menu collapse" id="service">
                  <li>New Service 1</li>
                  <li>New Service 2</li>
                  <li>New Service 3</li>
                </ul>
                 


                <li data-toggle="collapse" data-target="#new" class="collapsed">
                  <a href="#"><i class="fa fa-car fa-lg"></i> New <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="new">
                  <li>New New 1</li>
                  <li>New New 2</li>
                  <li>New New 3</li>
                </ul>
				-->

                 <li>
                  <a href="user" class="menulink">
                  <i class="fa fa-user fa-lg"></i> Profile
                  </a>
                  </li>

                 <li>
                  <a href="users" class="menulink">
                  <i class="fa fa-users fa-lg"></i> Users
                  </a>
                </li>
                
                 <li>
                  <a href="overview" class="menulink">
                  <i class="fa fa-plane fa-lg"></i> Overview
                  </a>
                </li>                
            </ul>
     </div>
</div>
<div class="" id="mycontent">
		Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
		Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
		when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
		It has survived not only five centuries, but also the leap into electronic typesetting, 
		remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets 
		containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker 
		including versions of Lorem Ipsum.
</div>


<script>

	$(document).ready(function(){

		$(".menulink").click(function(event){
			event.preventDefault();
			var link = $(this).attr("href");
			loadPage(link);
			
		});
	});

	function loadPage(link){

		var contentContainer = $("#mycontent");
		
		$("body").css("cursor", "progress");
		
		$.ajax({
			url: link,
			method:"GET",
			async : true
		})
		.done(function(data){
			contentContainer.html(data);
			$("body").css("cursor", "default");
		})
		.fail( function(data){
			contentContainer.html(data);
			$("body").css("cursor", "default");
		});
	}
</script>