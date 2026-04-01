<div class="question two-options" id="question-{{$item->id}}" >
    <p class="statement">{{$item->question}}</p>
    <div class="answer-container">
        @if(isset($item->answers) && count($item->answers)==2)
            <span class="agree two-options">{{$item->answers[0]['answer']}}</span>
            <div class="group__options two-options">
                <div class="option-wrapper two-options">
                    <label class="sp-radio" >
                        <input wire:click="answerQuestion('{{$item->id}}','{{$item->course_id}}','a')" onclick="clearChecked(this)" type="radio" value="A" name="question-{{$item->id}}" class="question-radio" data-type="value-{{$item->id}}" @if(isset($selAnswers[$item->id]['answer']) && $selAnswers[$item->id]['answer']=='a') checked @else data-reset="true"  @endif >

                        @if(isset($selAnswers[$item->id]['answer']) && $selAnswers[$item->id]['answer']=='a')
                            <div class="radio__tick"></div>
                        @else
                            <div class="radio__tick"></div>
                        @endif
                    </label>
                    <label class="option-description">A</label>
                </div>

                <div class="option-wrapper two-options">
                    <label class="sp-radio" >
                        <input wire:click="answerQuestion('{{$item->id}}','{{$item->course_id}}','b')" onclick="clearChecked(this)"  type="radio" value="B" name="question-{{$item->id}}" class="question-radio" data-type="value-{{$item->id}}" @if(isset($selAnswers[$item->id]['answer']) && $selAnswers[$item->id]['answer']=='b') checked @else data-reset="true" @endif>
                        @if(isset($selAnswers[$item->id]['answer']) && $selAnswers[$item->id]['answer']=='b')
                            <div class="radio__tick"></div>
                        @else
                            <div class="radio__tick"></div>
                        @endif
                    </label>
                    <label class="option-description">B</label>
                </div>
            </div>
            <span class="disagree two-options">{{$item->answers[1]['answer']}}</span>
        @endif

    </div>
    <hr>
</div>
