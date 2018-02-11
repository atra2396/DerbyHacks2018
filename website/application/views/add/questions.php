<div class="container-fluid">
<div class="jumbotron">

    <h2>Add a Question</h2>

    <form action="" method="post">
        <div class="form-group">
            <textarea class="form-control" name="question" placeholder="Question" required="" value="<?php echo !empty($meds['directions'])?$meds['directions']:''; ?>" rows="3" maxlength="280"></textarea>
          <?php echo form_error('directions','<span class="help-block">','</span>'); ?>
        </div>
        <button type="submit" name="qSubmit" class="btn btn-primary" value="Submit">Submit</button>
    </form>
    </div>
</div>
