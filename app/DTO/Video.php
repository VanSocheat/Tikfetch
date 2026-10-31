<?php
namespace App\DTO;
final readonly class Video {
 public function __construct(public string $id, public string $author, public string $url, public ?string $caption=null, public ?string $thumbnail=null, public ?int $duration=null, public ?string $createdAt=null, public bool $downloadable=false, public bool $sample=false) {}
 public function toArray(): array {return get_object_vars($this);}
}
