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

namespace Indoctrinated\Repository;

use Doctrine\ORM\Tools\EntityRepositoryGenerator;

class Generator
    extends EntityRepositoryGenerator
{

    /**
     * @param string $fullClassName
     * @param string $outputDirectory
     *
     * @return void
     */
    public function writeEntityRepositoryClass(
        $fullClassName,
        $outputDirectory
    )
    {
        $code = $this->generateEntityRepositoryClass($fullClassName);

        $paths = explode('\\', $fullClassName);
        $paths[] = end($paths);

        $path = $outputDirectory . DIRECTORY_SEPARATOR
            . implode(DIRECTORY_SEPARATOR, $paths) . '.php';
        $dir = dirname($path);

        if ( ! is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        if ( ! file_exists($path)) {
            file_put_contents($path, $code);
            chmod($path, 0664);
        }
    }
}
