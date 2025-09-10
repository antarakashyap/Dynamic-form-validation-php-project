<?php if ($step === 1): ?>
<form method="post">
    <p>Select fields you want in the form:</p>
    <div class="checkboxes">
        <label><input type="checkbox" name="fields[]" value="name"> Name</label><br>
        <label><input type="checkbox" name="fields[]" value="email"> Email</label><br>
        <label><input type="checkbox" name="fields[]" value="mobile"> Mobile</label><br>
        <label><input type="checkbox" name="fields[]" value="age"> Age</label><br>
        <label><input type="checkbox" name="fields[]" value="roll"> Roll Number</label><br>
        <label><input type="checkbox" name="fields[]" value="course"> Course Code</label><br>
        <label><input type="checkbox" name="fields[]" value="class"> Class</label><br>
        <label><input type="checkbox" name="fields[]" value="mcq" onclick="toggleMCQ(this)"> Multiple-choice Question</label>
        <div id="mcq_box" class="subquestion" style="display:none;">
            <input type="text" name="mcq_question" placeholder="Enter your MCQ question">
            <input type="text" name="mcq_options[]" placeholder="Option 1">
            <input type="text" name="mcq_options[]" placeholder="Option 2">
            <input type="text" name="mcq_options[]" placeholder="Option 3">
        </div>
        <label><input type="checkbox" name="fields[]" value="satisfaction" onclick="toggleSatisfaction(this)"> Satisfaction Rating</label>
        <div id="sat_box" class="subquestion" style="display:none;">
            <input type="text" name="satisfaction_question" placeholder="Enter your Satisfaction question">
        </div>
        <label><input type="checkbox" name="fields[]" value="like"> What did you like the most?</label><br>
        <label><input type="checkbox" name="fields[]" value="improve"> What can we improve?</label><br>
    </div>
    <button type="submit" name="choose_fields">Generate Form</button>
</form>
<?php elseif ($step === 2): ?>
    <?php if (!empty($errors)): ?>
        <div class="error"><ul><?php foreach ($errors as $err): ?><li><?= $err ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form method="post">
        <?php foreach ($selected as $field): ?>
            <?php
            if ($field === "name") echo '<input type="text" name="name" placeholder="Enter Name" value="'.htmlspecialchars($data['name']??'').'">';
            elseif ($field === "email") echo '<input type="text" name="email" placeholder="Enter Email" value="'.htmlspecialchars($data['email']??'').'">';
            elseif ($field === "mobile") echo '<input type="text" name="mobile" placeholder="Enter Mobile No." value="'.htmlspecialchars($data['mobile']??'').'">';
            elseif ($field === "age") echo '<input type="number" name="age" placeholder="Enter Age" value="'.htmlspecialchars($data['age']??'').'">';
            elseif ($field === "roll") echo '<input type="text" name="roll" placeholder="Enter Roll Number" value="'.htmlspecialchars($data['roll']??'').'">';
            elseif ($field === "course") echo '<input type="text" name="course" placeholder="Enter Course Code" value="'.htmlspecialchars($data['course']??'').'">';
            elseif ($field === "class") echo '<input type="text" name="class" placeholder="Enter Class" value="'.htmlspecialchars($data['class']??'').'">';
            elseif ($field === "mcq"){
                echo '<p><b>'.htmlspecialchars($questions["mcq"]["question"]).'</b></p>';
                foreach($questions['mcq']['options'] as $opt){
                    echo '<label><input type="radio" name="mcq" value="'.htmlspecialchars($opt).'" '.((isset($data['mcq']) && $data['mcq']==$opt)?"checked":"").'> '.htmlspecialchars($opt).'</label><br>';
                }
            }
            elseif ($field === "satisfaction"){
                echo '<p><b>'.htmlspecialchars($questions["satisfaction"]).'</b></p><select name="satisfaction">
                <option value="">-- Select --</option>
                <option value="Very Satisfied">Very Satisfied</option>
                <option value="Satisfied">Satisfied</option>
                <option value="Neutral">Neutral</option>
                <option value="Dissatisfied">Dissatisfied</option>
                <option value="Very Dissatisfied">Very Dissatisfied</option>
                </select>';
            }
            elseif ($field === "like") echo '<textarea name="like" placeholder="What did you like the most?">'.htmlspecialchars($data['like']??'').'</textarea>';
            elseif ($field === "improve") echo '<textarea name="improve" placeholder="What can we improve?">'.htmlspecialchars($data['improve']??'').'</textarea>';
            ?>
        <?php endforeach; ?>
        <div id="custom_questions_container"></div>
        <button type="button" onclick="addCustomQuestion()">+ Add a Question</button>
        <input type="hidden" name="selected" value="<?= implode(',', $selected) ?>">
        <input type="hidden" name="questions" value='<?= json_encode($questions) ?>'>
        <button type="submit" name="submit_form">Submit</button>
    </form>
<?php elseif ($step === 3): ?>
    <p class="success">✅ Form submitted successfully!</p>
    <h3>Your Responses:</h3>
    <ul>
        <?php foreach ($data as $field => $value): ?>
            <li><b><?= ucfirst($field) ?>:</b> <?= htmlspecialchars($value) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>