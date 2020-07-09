<?php ob_start();
use App\Entity\Quiz;
?>

<div class="container col-lg-11">
    <img class="img-fluid rounded mb-4" src="http://placehold.it/1200x300" alt="">

    <!-- ALL QUIZ -->
    <div class="row">
        <?php 
        foreach ($quiz as $oneQuiz) {
            $oneQuiz = new Quiz($oneQuiz);
            echo '<div class="col-lg-3 mb-4">
                      <div class="card h-100">
                          <h4 class="card-header">'.$oneQuiz->nameQuiz().'</h4>
                          <img src="public/images/img_quiz/'.$oneQuiz->imageQuiz().'" style="height: 250px; max-width: 100%;" alt="Image quiz">
                          <div class="card-footer">
                              <a href="#" class="btn btn-primary">Lancer ce quiz</a>
                          </div>
                      </div>
                  </div>';
        }
        ?>
    </div>
<!-- END ROW ALL QUIZ -->
</div>

<?php 
$content = ob_get_clean();
require('template_frontend.php');
?>