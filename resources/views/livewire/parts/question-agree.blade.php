<div class="question" id="question-{{$item->id}}" >
    <p class="statement">{{$item->question}}</p>
    <div class="answer-container">
        <div class="group__options">
            <div class="option-wrapper">
                <label class="sp-radio">
                    <input type="radio" wire:click="answerQuestion('{{$item->id}}','{{$item->course_id}}','5')"  name="question-agree-{{$item->id}}" onclick="clearChecked(this)" value="5" class="question-radio" data-type="value-{{$item->id}}" @if(isset($selAnswers[$item->id]['points']) && $selAnswers[$item->id]['points']=='5') checked @else data-reset="true" @endif >
                    <div class="radio__tick"></div>
                </label>
                <label class="option-description">Souhlasí</label>
            </div>
            <div class="option-wrapper">
                <label class="sp-radio">
                    <input type="radio" wire:click="answerQuestion('{{$item->id}}','{{$item->course_id}}','4')" name="question-agree-{{$item->id}}" onclick="clearChecked(this)" value="4" class="question-radio" data-type="value-{{$item->id}}" @if(isset($selAnswers[$item->id]['points']) && $selAnswers[$item->id]['points']=='4') checked @else data-reset="true" @endif >
                    <div class="radio__tick"></div>
                </label>
                <label class="option-description">Částečně souhlasí</label>
            </div>
            <div class="option-wrapper">
                <label class="sp-radio">
                    <input type="radio" wire:click="answerQuestion('{{$item->id}}','{{$item->course_id}}','3')" name="question-agree-{{$item->id}}" onclick="clearChecked(this)"  value="3" class="question-radio" data-type="value-{{$item->id}}" @if(isset($selAnswers[$item->id]['points']) && $selAnswers[$item->id]['points']=='3') checked @else data-reset="true" @endif >
                    <div class="radio__tick"></div>
                </label>
                <label class="option-description">Neutrální</label>
            </div>
            <div class="option-wrapper">
                <label class="sp-radio">
                    <input type="radio" wire:click="answerQuestion('{{$item->id}}','{{$item->course_id}}','2')" name="question-agree-{{$item->id}}" onclick="clearChecked(this)" value="2" class="question-radio" data-type="value-{{$item->id}}" @if(isset($selAnswers[$item->id]['points']) && $selAnswers[$item->id]['points']=='2') checked @else data-reset="true" @endif >
                    <div class="radio__tick"></div>
                </label>
                <label class="option-description">Částečně nesouhlasí</label>
            </div>
            <div class="option-wrapper">
                <label class="sp-radio">
                    <input type="radio" wire:click="answerQuestion('{{$item->id}}','{{$item->course_id}}','1')" name="question-agree-{{$item->id}}" onclick="clearChecked(this)"  value="1" class="question-radio" data-type="value-{{$item->id}}" @if(isset($selAnswers[$item->id]['points']) && $selAnswers[$item->id]['points']=='1') checked @else data-reset="true" @endif >
                    <div class="radio__tick"></div>
                </label>
                <label class="option-description">Nesouhlasí</label>
            </div>
        </div>
    </div>
    <hr>
</div>
