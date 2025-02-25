<?php

namespace App\Filament\Pages\Landing;

use App\Models\PageSection;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\Str;

class AboutSection extends Page
{
    use InteractsWithFormActions;

    protected static ?string $navigationGroup = 'Pages';
    protected static ?string $navigationParentItem = 'Landing';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.landing.about-section';
    public static string|Alignment $formActionsAlignment = Alignment::End;

    public ?array $data = [];
    public ?PageSection $model;

    /**
     * Get slug that preserve the page's hierarchical structure.
     * 
     * @return string
     */
    public static function getSlug(): string
    {
        $segments = [
            Str::kebab(static::getNavigationGroup()),
            Str::kebab(static::getNavigationParentItem()),
            Str::kebab(static::getNavigationLabel())
        ];

        return implode('/', $segments);
    }

    /**
     * Initialize from state.
     * 
     * @return void
     */
    public function mount(): void
    {
        $this->model = PageSection::where('type', 'about')->first();

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
                TextInput::make('content.heading')
                    ->label('Heading')
                    ->placeholder('Enter Heading')
                    ->required()
                    ->maxLength(255),

                Textarea::make('content.description')
                    ->label('Description')
                    ->placeholder('Enter Description')
                    ->rows(5)
                    ->required()
                    ->minLength(300)
                    ->maxLength(1000),

                FileUpload::make('content.illustration')
                    ->label('Illustration')
                    ->hint('Maximum 2MB.')
                    ->disk('public')
                    ->directory('images/pages/landing/about-section')
                    ->fetchFileInformation(false)
                    ->imageResizeMode('cover')
                    ->required()
                    ->image()
                    ->maxSize(2048),
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
    protected function getFormActions(): array
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
            Filament::getNavigation()[static::getNavigationGroup()]
                ->getItems()[static::getNavigationParentItem()]->getUrl() => static::getNavigationParentItem(),
            static::getNavigationLabel(),
        ];
    }
}
