<?php

namespace App\Filament\Pages\Landing;

use App\Models\PageSection;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\Str;

class ContactSection extends Page
{
    use InteractsWithFormActions;

    protected static ?string $navigationGroup = 'Pages';
    protected static ?string $navigationParentItem = 'Landing';
    protected static ?int $navigationSort = 3;
    protected static string $view = 'filament.pages.landing.contact-section';
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
        $this->model = PageSection::where('type', 'contact')->first();

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

                TextInput::make('content.phone')
                    ->label('Phone Number')
                    ->placeholder('Enter Phone Phone')
                    ->required()
                    ->tel()
                    ->maxLength(255),

                TextInput::make('content.email')
                    ->label('Email Address')
                    ->placeholder('Enter Email Address')
                    ->required()
                    ->email()
                    ->maxLength(255),

                TextInput::make('content.address')
                    ->label('Address')
                    ->placeholder('Enter Address')
                    ->required()
                    ->maxLength(255),

                TextInput::make('content.cta_text')
                    ->label('Email Button Text')
                    ->placeholder('Enter Email Button Text')
                    ->required()
                    ->maxLength(255),

                TextInput::make('content.cta_email')
                    ->label('Email Button Email Address')
                    ->placeholder('Enter Email Button Email Address')
                    ->required()
                    ->email()
                    ->maxLength(255),
            ])
            ->columns(2)
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
     * @return array
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
