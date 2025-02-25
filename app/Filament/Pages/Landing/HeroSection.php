<?php

namespace App\Filament\Pages\Landing;

use App\Models\PageSection;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\Str;

class HeroSection extends Page
{
    use InteractsWithFormActions;

    protected static ?string $navigationGroup = 'Pages';
    protected static ?string $navigationParentItem = 'Landing';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.landing.hero-section';
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
     * Initialize form state.
     * 
     * @return void
     */
    public function mount(): void
    {
        $this->model = PageSection::where('type', 'hero')->first();

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
                ...$this->getHeadingFields(),
                ...$this->getCTAFields(),
                ...$this->getImageUploadFields()
            ])
            ->columns(['default' => 4])
            ->model($this->model)
            ->statePath('data')
            ->operation('edit');
    }

    /**
     * Get text tagline and heading fields.
     * 
     * @return array
     */
    protected function getHeadingFields(): array
    {
        return [
            TextInput::make('content.tagline')
                ->label('Tagline')
                ->placeholder('Enter Tagline')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            TextInput::make('content.main_heading')
                ->label('Main Heading')
                ->placeholder('Enter Main Heading')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            TextInput::make('content.sub_heading')
                ->label('Sub Heading')
                ->placeholder('Enter Sub Heading')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
        ];
    }

    /**
     * Get CTA fields. 
     * 
     * @return array
     */
    protected function getCTAFields(): array
    {
        $sectionOptions = $this->model
            ->page
            ->sections
            ->where('id', '!=', $this->model->id)
            ->pluck('type')
            ->mapWithKeys(fn ($type) => ["#{$type}" => ucfirst($type)])
            ->toArray();

        return [
            TextInput::make('content.cta_text')
                ->label('CTA Text')
                ->placeholder('Enter Call-To-Action Text')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Select::make('content.cta_type')
                ->label('CTA Type')
                ->options([
                    'section' => 'Go To Section',
                    'url' => 'Go To URL'
                ])
                ->selectablePlaceholder(false)
                ->live()
                ->required()
                ->columnSpan([
                    'default' => 2,
                    'lg' => 1
                ]),

            Select::make('content.cta_link')
                ->label('Section')
                ->options($sectionOptions)
                ->selectablePlaceholder(false)
                ->hidden(fn (Get $get): bool => $get('content.cta_type') !== 'section')
                ->beforeStateDehydrated(
                    static function (Select $component, string $state) use ($sectionOptions): void {
                        array_key_exists($state, $sectionOptions)
                            ?: $component->state(array_key_first($sectionOptions));
                    }
                )
                ->required()
                ->columnSpan([
                    'default' => 2,
                    'lg' => 3
                ]),

            TextInput::make('content.cta_link')
                ->label('CTA URL')
                ->placeholder('Enter Call-To-Action Url')
                ->hidden(fn (Get $get): bool => $get('content.cta_type') !== 'url')
                ->url()
                ->required()
                ->maxLength(255)
                ->columnSpan([
                    'default' => 2,
                    'lg' => 3
                ]),
        ];
    }

    /**
     * Get image upload fields.
     * 
     * @return array
     */
    protected function getImageUploadFields(): array
    {
        return [
            FileUpload::make('content.background_images')
                ->label('Background Images')
                ->hint('Upload between 12 to 24 images. Maximum 2MB per image.')
                ->disk('public')
                ->directory('images/pages/landing/hero-section/thumbnails')
                ->fetchFileInformation(false)
                ->multiple()
                ->imageResizeMode('cover')
                ->reorderable()
                ->panelLayout('grid')
                ->image()
                ->maxSize(2048)
                ->minFiles(12)
                ->maxFiles(24)
                ->columnSpanFull()
                ->extraAttributes(['class' => '[&_.filepond--item]:!w-[calc(100%-0.5rem)] sm:[&_.filepond--item]:!w-[calc(50%-0.5rem)] md:[&_.filepond--item]:!w-[calc(33.33%-0.5rem)] lg:[&_.filepond--item]:!w-[calc(25%-0.5rem)]']),

            FileUpload::make('content.slider_images')
                ->label('Slider Images')
                ->hint('Upload between 12 to 24 images. Maximum 1MB per image.')
                ->disk('public')
                ->directory('images/pages/landing/hero-section/logos')
                ->fetchFileInformation(false)
                ->multiple()
                ->imageResizeMode('cover')
                ->reorderable()
                ->panelLayout('grid')
                ->image()
                ->maxSize(1024)
                ->minFiles(12)
                ->maxFiles(24)
                ->columnSpanFull()
                ->extraAttributes(['class' => '[&_.filepond--item]:!w-[calc(33.33%-0.5rem)] sm:[&_.filepond--item]:!w-[calc(25%-0.5rem)] md:[&_.filepond--item]:!w-[calc(16.66%-0.5rem)]']),
        ];
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
