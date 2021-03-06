<?php


namespace App\DataPersister;


use App\Entity\Dog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\String\Slugger\SluggerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Security;

class DogDataPersister implements ContextAwareDataPersisterInterface
{
     

    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;
    private $_slugger;

    public function __construct(
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ) {
        $this->_entityManager = $entityManager;
        $this->_slugger = $slugger;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Dog;
    }
    /**
     * @param Security
     */
    private $_security;

    


    /**
     * @param Article $data
     */
    public function persist($data, array $context = [])
    {
        // Update the slug only if the article isn't published
        if (!$data->getIsPublished()) {
            $data->setSlug(
                $this
                    ->_slugger
                    ->slug(strtolower($data->getTitle())). '-' .uniqid()
            );
        }

        // Set the author if it's a new article
        if ($this->_request->getMethod() === 'POST') {
            $data->setAuthor($this->_security->getUser());
        }

        // Set the updatedAt value if it's not a POST request
        if ($this->_request->getMethod() !== 'POST') {
            $data->setUpdatedAt(new \DateTime());
        }

        $tagRepository = $this->_entityManager->getRepository(Tag::class);
        foreach ($data->getTags() as $tag) {
            $t = $tagRepository->findOneByLabel($tag->getLabel());

            // if the tag exists, don't persist it
            if ($t !== null) {
                $data->removeTag($tag);
                $data->addTag($t);
            } else {
                $this->_entityManager->persist($tag);
            }
        }

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }

    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
    
}