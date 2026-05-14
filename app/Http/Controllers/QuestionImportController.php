```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use PhpOffice\PhpWord\IOFactory;

class QuestionImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'docx_file' => 'required|mimes:docx'
        ]);

        $file = $request->file('docx_file');
        $phpWord = IOFactory::load($file->getPathname());

        $fullText = '';

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {

                if (method_exists($element, 'getText')) {
                    $fullText .= $element->getText() . "\n";
                }

                if (method_exists($element, 'getElements')) {
                    foreach ($element->getElements() as $child) {
                        if (method_exists($child, 'getText')) {
                            $fullText .= $child->getText() . "\n";
                        }
                    }
                }
            }
        }

        $questions = explode('{END}', $fullText);

        foreach ($questions as $questionBlock) {

            if (trim($questionBlock) == '') {
                continue;
            }

            $data = $this->parseQuestion($questionBlock);

            // Question::create([
            //     'question_html' => $this->toHtml($data['question']),
            //     'option_1' => $this->toHtml($data['option_1']),
            //     'option_2' => $this->toHtml($data['option_2']),
            //     'option_3' => $this->toHtml($data['option_3']),
            //     'option_4' => $this->toHtml($data['option_4']),
            //     'answer' => $data['answer']
            // ]);
        }

        return back()->with('success', 'Questions imported successfully');
    }

    private function parseQuestion($text)
    {
        preg_match('/\{QUESTION\}(.*?)\{OPTION_1\}/s', $text, $question);
        preg_match('/\{OPTION_1\}(.*?)\{OPTION_2\}/s', $text, $option1);
        preg_match('/\{OPTION_2\}(.*?)\{OPTION_3\}/s', $text, $option2);
        preg_match('/\{OPTION_3\}(.*?)\{OPTION_4\}/s', $text, $option3);
        preg_match('/\{OPTION_4\}(.*?)\{ANSWER\}/s', $text, $option4);
        preg_match('/\{ANSWER\}(.*)/s', $text, $answer);

        return [
            'question' => trim($question[1] ?? ''),
            'option_1' => trim($option1[1] ?? ''),
            'option_2' => trim($option2[1] ?? ''),
            'option_3' => trim($option3[1] ?? ''),
            'option_4' => trim($option4[1] ?? ''),
            'answer' => trim($answer[1] ?? '')
        ];
    }

    private function toHtml($text)
    {
        $text = nl2br($text);

        $text = preg_replace('/\^(\d+)/', '<sup>$1</sup>', $text);
        $text = preg_replace('/_(\d+)/', '<sub>$1</sub>', $text);

        $text = str_replace('/', '&divide;', $text);
        $text = str_replace('*', '&times;', $text);

        return "<p>{$text}</p>";
    }
}

?>