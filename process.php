<?php
$step = 1;
$selected = [];
$errors = [];
$data = [];
$questions = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['choose_fields'])) {
        $selected = isset($_POST['fields']) ? $_POST['fields'] : [];
        if (in_array("mcq", $selected)) {
            $questions['mcq'] = [
                'question' => $_POST['mcq_question'] ?? "Your MCQ Question",
                'options' => array_filter($_POST['mcq_options'] ?? [])
            ];
        }
        if (in_array("satisfaction", $selected)) {
            $questions['satisfaction'] = $_POST['satisfaction_question'] ?? "How satisfied are you?";
        }
        if (!empty($selected)) $step = 2;
    } elseif (isset($_POST['submit_form'])) {
        $selected = explode(",", $_POST['selected']);
        $questions = json_decode($_POST['questions'], true);

        foreach ($selected as $field) {
            $value = trim($_POST[$field] ?? "");
            switch ($field) {
                case "name":
                    if (empty($value) || !preg_match("/^[a-zA-Z ]+$/", $value)) $errors[] = "Valid name is required.";
                    break;
                case "email":
                    if (empty($value) || !filter_var($value, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
                    break;
                case "mobile":
                    if (empty($value) || !preg_match("/^[0-9]{10}$/", $value)) $errors[] = "Valid 10-digit mobile number is required.";
                    break;
                case "age":
                    if (empty($value) || !is_numeric($value) || $value < 1 || $value > 120) $errors[] = "Valid age is required.";
                    break;
                case "roll":
                case "course":
                case "class":
                case "like":
                case "improve":
                    if (empty($value)) $errors[] = ucfirst($field)." is required.";
                    break;
                case "mcq":
                case "satisfaction":
                    if (empty($value)) $errors[] = $questions[$field]['question'] ?? "This question is required.";
                    break;
            }
            $data[$field] = $value;
        }

        if (!empty($_POST['custom_questions'])) {
            foreach ($_POST['custom_questions'] as $cq) {
                $question = trim($cq['text'] ?? '');
                $answer = trim($cq['answer'] ?? '');
                if ($question !== '') $data[$question] = $answer ?: "No answer";
            }
        }

        $step = empty($errors) ? 3 : 2;
    }
}
?>