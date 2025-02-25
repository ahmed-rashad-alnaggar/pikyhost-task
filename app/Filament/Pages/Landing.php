<?php

namespace App\Filament\Pages;

use App\Models\Page as PageModel;
use Filament\Actions\Action;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Filament\Support\Enums\Alignment;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Str;

class Landing extends Page
{
    use InteractsWithFormActions;

    protected static ?string $navigationGroup = 'Pages';
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.landing';
    public static string|Alignment $formActionsAlignment = Alignment::End;

    public ?array $data = [];
    public ?PageModel $model;

    /**
     * Get slug that preserve the page's hierarchical structure.
     * 
     * @return string
     */
    public static function getSlug(): string
    {
        $segments = [
            Str::kebab(static::getNavigationGroup()),
            Str::kebab(static::getNavigationLabel())
        ];

        return implode('/', $segments);
    }

    /**
     * Initialize form state.
     * 
     * @return void
     */
    public function mount(): void
    {
        $this->model = PageModel::where('type', 'landing')->first();

        $this->form->fill($this->model->attributesToArray());
    }

    /**
     * Configure the form structure.
     * 
     * @param \Filament\Forms\Form $form
     * @return \Filament\Forms\Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Title')
                    ->placeholder('Enter Title')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->label('Slug')
                    ->helperText('The slug is read-only.')
                    ->disabled(),

                TagsInput::make('seo_keywords')
                    ->label('SEO Keywords')
                    ->placeholder('Enter SEO Keywords')
                    ->validationAttribute('SEO Keywords')
                    ->helperText('Separate keywords with commas. Maximum 10 keywords allowed.')
                    ->separator(',')
                    ->splitKeys([','])
                    ->required()
                    ->rules(['max:10'])
                    ->nestedRecursiveRules([
                        'max:25'
                    ])
                    ->validationMessages([
                        'max' => 'You can only enter a maximum of 10 keywords.',
                        '*.max' => 'Each keyword must not exceed :max characters.'
                    ]),

                Textarea::make('seo_description')
                    ->label('SEO Description')
                    ->placeholder('Enter SEO Description')
                    ->validationAttribute('SEO Description')
                    ->rows(5)
                    ->required()
                    ->minLength(50)
                    ->maxLength(1000)
            ])
            ->model($this->model)
            ->statePath('data')
            ->operation('edit');
    }

    /**
     * Get form actions.
     * 
     * @return array
     */
    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }

    /**
     * Handle form submission.
     * 
     * @return void
     */
    public function save(): void
    {
        try {
            $data = $this->form->getState();

            $this->model->update($data);
        } catch (Halt) {
            return;
        }

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }

    /**
     * Get breadcrumbs that preserve the page's hierarchical structure.
     * 
     * @return string
     */
    public function getBreadcrumbs(): array
    {
        return [
            static::getNavigationGroup(),
            static::getNavigationLabel(),
        ];
    }
}
