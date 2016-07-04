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

namespace Indoctrinated\Tools\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\ORM\Version;

class ConsoleRunner
    extends \Doctrine\ORM\Tools\Console\ConsoleRunner
{
    /**
     * Runs console with the given helperset.
     *
     * @param \Symfony\Component\Console\Helper\HelperSet  $helperSet
     * @param \Symfony\Component\Console\Command\Command[] $commands
     *
     * @return void
     */
    static public function run(HelperSet $helperSet, $commands = array())
    {
        $cli = static::createApplication($helperSet, $commands);
        $cli->run();
    }

    /**
     * Creates a console application with the given helperset and
     * optional commands.
     *
     * @param \Symfony\Component\Console\Helper\HelperSet $helperSet
     * @param array $commands
     *
     * @return \Symfony\Component\Console\Application
     */
    static public function createApplication(HelperSet $helperSet, $commands = array())
    {
        $cli = new Application('Doctrine Command Line Interface', Version::VERSION);
        $cli->setCatchExceptions(true);
        $cli->setHelperSet($helperSet);
        static::addCommands($cli);
        $cli->addCommands($commands);

        return $cli;
    }

    static public function addCommands(Application $cli)
    {
        $cli->addCommands(array(
            // DBAL Commands
            new \Doctrine\DBAL\Tools\Console\Command\RunSqlCommand(),
            new \Doctrine\DBAL\Tools\Console\Command\ImportCommand(),

            // ORM Commands
            new \Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand(),
            new \Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand(),
            new \Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand(),
            new \Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand(),
            new \Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand(),
            new \Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand(),
            new \Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand(),
            new \Doctrine\ORM\Tools\Console\Command\ConvertDoctrine1SchemaCommand(),
            new Command\GenerateRepositoriesCommand(),
            new Command\GenerateEntitiesCommand(),
            new \Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand(),
            new Command\ConvertMappingCommand(),
            new \Doctrine\ORM\Tools\Console\Command\RunDqlCommand(),
            new \Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand(),
            new \Doctrine\ORM\Tools\Console\Command\InfoCommand(),
            new \Doctrine\ORM\Tools\Console\Command\MappingDescribeCommand(),
        ));
    }
}