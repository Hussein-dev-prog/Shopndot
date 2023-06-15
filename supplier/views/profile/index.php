<?php

use yii\helpers\Html;
use common\models\Supplier;
use yii\helpers\Url;

$this->title = "Profile";
?>

<?php if (!$profileExists) : ?>
    <div style="display:flex;flex-direction:column;align-items:center;justify-content:center">
        <a href="<?php echo Url::to(['/profile/update']) ?>" class="btn btn-danger">
            Update your Profile
        </a>
    </div>

<?php endif; ?>


<?php if ($profileExists) : ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div style="display:flex;flex-direction:column;align-items:center;justify-content:center">
                    <h1>Profile Details</h1>
                    <div style="display:flex;flex-direction:column;align-items:center;justify-content:center">
                        <h2><?= $profile->name ?></h2>
                        <?php if ($profile->logo) : ?>
                            <img style="width: 200px; height: 200px; object-fit: cover; border-radius: 100%;" src="<?= $profile->logo ?>" alt="<?= $profile->name ?>">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <?php foreach ($socials as $social) : ?>
                    <p><?= $social->provider ?></p>
                    <p><?= $social->link ?></p>
                    <?php endforeach; ?>
            </div>
            <div class="mt-5" style="text-align:center">
                <?= Html::a("Edit", ['profile/update'], ['class' => 'btn btn-primary']); ?>
                <?= Html::a("Delete", ['profile/delete'], ['class' => 'btn btn-danger']); ?>
            </div>
        </div>
    </div>



<?php endif; ?>
</div>