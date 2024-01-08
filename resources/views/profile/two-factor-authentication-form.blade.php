<x-action-section>
    <x-slot name="title">
        {{ __('Your quiz rezults') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Check your quiz performance summary here. Review correct answers, identify areas for improvement, and track your progress over time. Keep challenging yourself for ongoing success! 🏆') }}
    </x-slot>

    <x-slot name="content">
        <div style="display: flex; justify-content: space-between;">
            <div style="color: green;">Correctly picked answers: 70%</div>
            <div style="color: red;">Incorrectly picked answers: 30%</div>
        </div>
        <div style="display: flex; justify-content: space-between; margin-top: 10px;">
            <div>Lowest time taken to complete a quiz: 1:58</div>
            <div>Longest time taken to complete a quiz: 8:12</div>
        </div>
    </x-slot>
</x-action-section>
