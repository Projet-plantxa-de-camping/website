<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom de l\'article'
            ])
            ->add('price', TextType::class, [
                'required' => true,
                'label' => 'Prix de l\'article'
            ])
            ->add('category',EntityType::class,[
                'class' => Category::class,
                'choice_label' => 'title',
                'label' => 'Catégorie'
                ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => 'image article',
                'label_attr' => [
                    'data-browse' => 'Parcourir'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
