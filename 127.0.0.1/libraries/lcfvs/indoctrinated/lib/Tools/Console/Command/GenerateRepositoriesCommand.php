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

use Indoctrinated\Repository\Generator;
use Doctrine\ORM\Tools\Console;
use Doctrine\ORM\Tools\Console\MetadataFilter;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Command to generate repository classes for mapping information.
 *
 * @link    www.doctrine-project.org
 * @since   2.0
 * @author  Benjamin Eberlei <kontakt@beberlei.de>
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Jonathan Wage <jonwage@gmail.com>
 * @author  Roman Borschel <roman@code-factory.org>
 */
class GenerateRepositoriesCommand
    extends Console\Command\GenerateRepositoriesCommand
{
    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getHelper('em')->getEntityManager();

        $metadatas = $em->getMetadataFactory()->getAllMetadata();
        $metadatas = MetadataFilter::filter($metadatas, $input->getOption('filter'));

        $repositoryName = $em->getConfiguration()->getDefaultRepositoryClassName();

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
            $numRepositories = 0;
            $generator = new Generator();

            $generator->setDefaultRepositoryName($repositoryName);

            foreach ($metadatas as $metadata) {
                if ($metadata->customRepositoryClassName) {
                    $output->writeln(
                        sprintf('Processing repository "<info>%s</info>"', $metadata->customRepositoryClassName)
                    );

                    $generator->writeEntityRepositoryClass($metadata->customRepositoryClassName, $destPath);

                    $numRepositories++;
                }
            }

            if ($numRepositories) {
                // Outputting information message
                $output->writeln(PHP_EOL . sprintf('Repository classes generated to "<info>%s</INFO>"', $destPath) );
            } else {
                $output->writeln('No Repository classes were found to be processed.' );
            }
        } else {
            $output->writeln('No Metadata Classes to process.' );
        }
    }
}
