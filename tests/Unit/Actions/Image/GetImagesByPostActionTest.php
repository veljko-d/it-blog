<?php

namespace Tests\Unit\Actions\Image;

use App\Actions\Image\GetImagesByPostAction;
use Tests\Unit\Actions\ImageActionTestCase;

/**
 * Class GetImagesByPostActionTest
 *
 * @package Tests\Unit\Actions\Image
 */
class GetImagesByPostActionTest extends ImageActionTestCase
{
    /**
     * @return GetImagesByPostAction
     */
    private function getGetImagesByPostAction(): GetImagesByPostAction
    {
        return new GetImagesByPostAction(
            $this->logger,
            $this->imageModel,
            $this->image,
            $this->storage
        );
    }

    /**
     * @test
     */
    public function testGetImagesByPost()
    {
        $getImagesByPostAction = $this->getGetImagesByPostAction();

        $images = ['image_1' => 'Image-1', 'image_2' => 'Image-2'];

        $this->imageModel->expects($this->once())
            ->method('getByPost')
            ->with(3)
            ->will($this->returnValue($images));

        $result = $getImagesByPostAction->execute(3);

        $this->assertSame($result, $images);
    }
}
