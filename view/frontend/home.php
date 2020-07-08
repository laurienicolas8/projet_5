<?php ob_start();
use App\Entity\Quiz;
use App\Entity\Category;
?>

<!-- SLIDER -->
<div>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner" role="listbox">
            <!-- Slide One - Set the background image for this slide in the line below -->
            <div class="carousel-item active" style="background-image: url('http://placehold.it/1900x1080')">
                <div class="carousel-caption d-none d-md-block">
                    <h3>First Slide</h3>
                    <p>This is a description for the first slide.</p>
                </div>
            </div>

            <!-- Slide Two - Set the background image for this slide in the line below -->
            <div class="carousel-item" style="background-image: url('http://placehold.it/1900x1080')">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Second Slide</h3>
                    <p>This is a description for the second slide.</p>
                </div>
            </div>

            <!-- Slide Three - Set the background image for this slide in the line below -->
            <div class="carousel-item" style="background-image: url('http://placehold.it/1900x1080')">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Third Slide</h3>
                    <p>This is a description for the third slide.</p>
                </div>
            </div>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>


<!-- PAGE CONTENT -->
<div class="container">
    <h2 class="my-4 h2_home">Choisir par catégorie...</h2>

    <!-- CATEGORIES -->
    <div class="row">
        <div class='category_container'>
            <?php 
            foreach ($categories as $category) {
              $category = new Category($category);
              echo '<div class="category col-lg-2">
                        <a href="" class="img_category"><img src="public/images/img_categories/'.$category->imageCategory().'" alt="Illustration catégorie"></a>
                        <p class="title_category">'.$category->nameCategory().'</p>
                    </div>';
            }
            ?>
        </div>  
    </div>
    <!-- END ROW CATEGORIES -->

    <!-- QUIZ -->
    <h2 class='my-4 h2_home'>...ou en vrac !</h2>
    <div class="row">
        <?php 
        foreach ($homeQuiz as $quiz) {
            $quiz = new Quiz($quiz);
            echo '<div class="col-lg-4 col-sm-6 portfolio-item">
                      <div class="card h-100">
                          <a href="#"><img class="card-img-top" src="public/images/img_quiz/'.$quiz->imageQuiz().'" alt="Image quiz"></a>
                          <div class="card-body">
                              <h4 class="card-title">
                                  <a href="#">'.$quiz->nameQuiz().'</a>
                              </h4>                    
                          </div>
                      </div>
                  </div>';
        }
        ?>
        <div class="col-lg-12 div_button_all_quiz">
            <a href="" class="button_all_quiz">Voir tous les quiz</a>
        </div>
    </div>
    <!-- END ROW QUIZ -->
</div>

<?php 
$content = ob_get_clean();
require('template_frontend.php');
?>