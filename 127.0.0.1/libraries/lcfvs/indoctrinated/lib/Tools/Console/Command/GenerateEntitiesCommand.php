<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Indoctrinated\Tools\Console\Command;

use Doctrine\ORM\Tools\Console\MetadataFilter;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Indoctrinated\Tools\EntityGenerator;
use Indoctrinated\Tools\Console;

class GenerateEntitiesCommand
    extends \Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand
{

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getHelper('em')->getEntityManager();

        $cmf = new DisconnectedClassMetadataFactory();
        $cmf->setEntityManager($em);
        $metadatas = $cmf->getAllMetadata();
        $metadatas = MetadataFilter::filter($metadatas, $input->getOption('filter'));

        // Process destination directory
        $destPath = realpath($input->getArgument('dest-path'));

        if ( ! file_exists($destPath)) {
            throw new \InvalidArgumentException(
                sprintf("Entities destination directory '<info>%s</info>' does not exist.", $input->getArgument('dest-path'))
            );
        }

        if ( ! is_writable($destPath)) {
            throw new \InvalidArgumentException(
                sprintf("Entities destination directory '<info>%s</info>' does not have write permissions.", $destPath)
            );
        }

        if (count($metadatas)) {
            // Create EntityGenerator
            $entityGenerator = new EntityGenerator();

            $entityGenerator->setGenerateAnnotations($input->getOption('generate-annotations'));
            $entityGenerator->setGenerateStubMethods($input->getOption('generate-methods'));
            $entityGenerator->setRegenerateEntityIfExists($input->getOption('regenerate-entities'));
            $entityGenerator->setUpdateEntityIfExists($input->getOption('update-entities'));
            $entityGenerator->setNumSpaces($input->getOption('num-spaces'));
            $entityGenerator->setBackupExisting(!$input->getOption('no-backup'));

            if (($extend = $input->getOption('extend')) !== null) {
                $entityGenerator->setClassToExtend($extend);
            }

            foreach ($metadatas as $metadata) {
                $output->writeln(
                    sprintf('Processing entity "<info>%s</info>"', $metadata->name)
                );
            }

            // Generating Entities
            $entityGenerator->generate($metadatas, $destPath);

            // Outputting information message
            $output->writeln(PHP_EOL . sprintf('Entity classes generated to "<info>%s</INFO>"', $destPath));
        } else {
            $output->writeln('No Metadata Classes to process.');
        }
    }
}
