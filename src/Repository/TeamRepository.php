<?php

namespace App\Repository;

use App\Entity\Team;
use App\Service\AvatarUploader;
use App\Service\FileUploader;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @extends ServiceEntityRepository<Team>
 *
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    private $slugger;
    private $avatarUploader;
    public function __construct(ManagerRegistry $registry, SluggerInterface $slugger, AvatarUploader $avatarUploader)
    {
        parent::__construct($registry, Team::class);
        $this->slugger = $slugger;
        $this->avatarUploader = $avatarUploader;
    }

    public function add(Team $team, FormInterface $form,  bool $flush = false): void
    {
        $team = $form->getData();

        /** @var UploadedFile $avatar */
        $avatar = $form->get('imagePath')->getData();
        if ($avatar) {
            $avatar = $this->avatarUploader->upload($avatar);
            $team->setImagePath($avatar);
        }

        $this->getEntityManager()->persist($team);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function addWithFile(Team $team, FormInterface $form, string $targetDirectory,  bool $flush = false): void
    {

        $team = $form->getData();

        $thumbnail = $form->get('imagePath')->getData();
        if ($thumbnail) {   // thumbnail must be processed only when a file is uploaded
            $originalFilename = pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = $this->slugger->slug($originalFilename);    // this is needed to safely include the file name as part of the URL
            $newFilename = $safeFilename.'-'.uniqid().'.'.$thumbnail->guessExtension();

            try {   // Move the file to the directory where posts are stored
                $thumbnail->move($targetDirectory, $newFilename);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // store the post image name instead of its contents
            $team->setImagePath($newFilename);
        }

        $this->getEntityManager()->persist($team);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Team $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Team[] Returns an array of Team objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Team
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
