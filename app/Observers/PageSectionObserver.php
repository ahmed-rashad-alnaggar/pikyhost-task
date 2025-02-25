<?php

namespace App\Observers;

use App\Models\PageSection;
use Illuminate\Support\Facades\Storage;

class PageSectionObserver
{
    /**
     * Handle the PageSection "saved" event.
     * 
     * @return void
     */
    public function saved(PageSection $pageSection): void
    {
        switch ($pageSection->type) {
            case 'hero':
                $this->deleteHeroSectionUnusedImages($pageSection->getOriginal('content'), $pageSection->getAttributeValue('content'));
                break;
            case 'about':
                // Delete about section old illustration.

                $oldIllustration = $pageSection->getOriginal('content')['illustration'];
                $newIllustration = $pageSection->getAttributeValue('content')['illustration'];

                if ($oldIllustration !== $newIllustration) {
                    Storage::disk('public')->delete($oldIllustration);
                }
                break;
        }
    }

    /**
     * Delete hero section unused images.
     * 
     * @param array $oldHeroSectionContent
     * @param array $newHeroSectionContent
     * @return void
     */
    protected function deleteHeroSectionUnusedImages(array $oldHeroSectionContent, array $newHeroSectionContent): void
    {
        $unusedBackgroundImages = array_diff($oldHeroSectionContent['background_images'], $newHeroSectionContent['background_images']);
        $unusedSliderImages = array_diff($oldHeroSectionContent['slider_images'], $newHeroSectionContent['slider_images']);

        Storage::disk('public')->delete([...$unusedBackgroundImages, ...$unusedSliderImages]);
    }
}
