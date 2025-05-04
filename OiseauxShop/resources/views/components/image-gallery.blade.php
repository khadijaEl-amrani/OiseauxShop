@props(['images', 'title' => null])

<div class="image-gallery">
    @if($title)
        <h5 class="mb-3">{{ $title }}</h5>
    @endif
    
    @if(count($images) > 0)
        <div id="imageGallery" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($images as $key => $image)
                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                        <img src="{{ \App\Helpers\ImageHelper::getImageUrl($image->chemin_image) }}" 
                             class="d-block w-100 rounded" 
                             alt="Image {{ $key + 1 }}" 
                             style="height: 400px; object-fit: contain;">
                    </div>
                @endforeach
            </div>
            
            @if(count($images) > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#imageGallery" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#imageGallery" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                
                <div class="row mt-3">
                    @foreach($images as $key => $image)
                        <div class="col-3 mb-3">
                            <img src="{{ \App\Helpers\ImageHelper::getImageUrl($image->chemin_image) }}" 
                                 class="img-thumbnail announcement-image-thumbnail" 
                                 alt="Thumbnail {{ $key + 1 }}" 
                                 onclick="$('#imageGallery').carousel({{ $key }})">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <div class="bg-light d-flex justify-content-center align-items-center rounded" style="height: 400px;">
            <i class="fas fa-dove fa-5x text-muted"></i>
        </div>
    @endif
</div>