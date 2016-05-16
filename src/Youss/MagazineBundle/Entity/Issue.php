<?php

namespace Youss\MagazineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Issue
 *
 * @ORM\Table(name="issues")
 * @ORM\Entity(repositoryClass="Youss\MagazineBundle\Entity\IssueRepository")
 */
class Issue
{
    /**
     * @var Publication
     *
     * @ORM\ManyToOne(targetEntity="Publication", inversedBy="issues")
     * @ORM\JoinColumn(name="publication_id", referencedColumnName="id")
     */
    private $publication;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     *
     * @Assert\Range(
     *   min=1,
     *   minMessage="you will need to specify Issue 1 or higher."
     * )
     */
    private $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="date")
     */
    private $datePublication;

    /**
     * @var string
     *
     * @ORM\Column(name="cover", type="string", length=255, nullable=true)
     */
    private $cover;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Issue
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     * @return Issue
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime 
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Set cover
     *
     * @param string $cover
     * @return Issue
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return string 
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set publication
     *
     * @param \Youss\MagazineBundle\Entity\Publication $publication
     * @return Issue
     */
    public function setPublication(\Youss\MagazineBundle\Entity\Publication $publication = null)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return \Youss\MagazineBundle\Entity\Publication 
     */
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * Get web path to upload directory
     * @return string
     */
    protected function getUploadPath(){
        return 'uploads/covers';
    }

    /**
     * @return string
     * get absolute path to upload directory
     */
    protected function getUploadAbsolutePath(){
        return __DIR__.'/../../../../web/'.$this->getUploadPath();
    }

    /**
     * @return null|string
     * relative path
     */
    public function getCoverWeb(){
        return null === $this->getCover()
            ? null
            : $this->getUploadPath().'/'.$this->getCover();
    }

    /**
     * Get  path on disk to a cover
     * @return null|string
     */
    public function getCoverAbsolute(){
        return null === $this->getCover()
            ? null
            : $this->getUploadAbsolutePath().'/'.$this->getCover();
    }


    /**
     * @Assert\File(maxSize="1000000")
     */
    private $file;

    /**
     * @param UploadedFile $file
     * set file
     */
    public function setFile(UploadedFile $file= null){
        $this->file=$file;
    }

    /**
     * @return UploadedFile
     * get file
     */
    public function getFile(){
        return $this->file;
    }

    /**
     * upload a cover file
     */
    public function upload(){
        if($this->getFile()===null){
            return;
        }
        $filename = $this->getFile()->getClientOriginalName();

        $this->getFile()->move($this->getUploadAbsolutePath(), $filename);

        $this->setCover($filename);

        $this->setFile();
    }

}
