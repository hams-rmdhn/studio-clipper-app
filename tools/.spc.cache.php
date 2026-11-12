<?php return array (
  'attr:
  type: library
  artifact:
    source: \'https://download.savannah.nongnu.org/releases/attr/attr-2.5.2.tar.gz\'
    source-mirror: \'https://mirror.souseiseki.middlendian.com/nongnu/attr/attr-2.5.2.tar.gz\'
    metadata:
      license-files: [doc/COPYING.LGPL]
      license: LGPL-2.1-or-later
  static-libs@unix:
    - libattr.a
' => 
  array (
    'attr' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 'https://download.savannah.nongnu.org/releases/attr/attr-2.5.2.tar.gz',
        'source-mirror' => 'https://mirror.souseiseki.middlendian.com/nongnu/attr/attr-2.5.2.tar.gz',
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'doc/COPYING.LGPL',
          ),
          'license' => 'LGPL-2.1-or-later',
        ),
      ),
      'static-libs@unix' => 
      array (
        0 => 'libattr.a',
      ),
    ),
  ),
  'brotli:
  type: library
  artifact:
    source:
      type: ghtagtar
      repo: google/brotli
      match: \'v1\\.\\d.*\'
    metadata:
      license-files: [LICENSE]
      license: MIT
  headers:
    - brotli
  pkg-configs:
    - libbrotlicommon
    - libbrotlidec
    - libbrotlienc
  static-libs@windows:
    - brotlicommon.lib
    - brotlidec.lib
    - brotlienc.lib
' => 
  array (
    'brotli' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'google/brotli',
          'match' => 'v1\\.\\d.*',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'MIT',
        ),
      ),
      'headers' => 
      array (
        0 => 'brotli',
      ),
      'pkg-configs' => 
      array (
        0 => 'libbrotlicommon',
        1 => 'libbrotlidec',
        2 => 'libbrotlienc',
      ),
      'static-libs@windows' => 
      array (
        0 => 'brotlicommon.lib',
        1 => 'brotlidec.lib',
        2 => 'brotlienc.lib',
      ),
    ),
  ),
  'bzip2:
  type: library
  artifact:
    source:
      type: url
      url: \'https://dl.static-php.dev/static-php-cli/deps/bzip2/bzip2-1.0.8.tar.gz\'
    source-mirror:
      type: filelist
      url: \'https://sourceware.org/pub/bzip2/\'
      regex: \'/href="(?<file>bzip2-(?<version>[^"]+)\\.tar\\.gz)"/\'
    metadata:
      license-files: [\'@/bzip2.txt\']
      license: bzip2-1.0.6
  headers:
    - bzlib.h
  static-libs@unix:
    - libbz2.a
  static-libs@windows:
    - libbz2.lib
    - libbz2_a.lib
' => 
  array (
    'bzip2' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'url',
          'url' => 'https://dl.static-php.dev/static-php-cli/deps/bzip2/bzip2-1.0.8.tar.gz',
        ),
        'source-mirror' => 
        array (
          'type' => 'filelist',
          'url' => 'https://sourceware.org/pub/bzip2/',
          'regex' => '/href="(?<file>bzip2-(?<version>[^"]+)\\.tar\\.gz)"/',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => '@/bzip2.txt',
          ),
          'license' => 'bzip2-1.0.6',
        ),
      ),
      'headers' => 
      array (
        0 => 'bzlib.h',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libbz2.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'libbz2.lib',
        1 => 'libbz2_a.lib',
      ),
    ),
  ),
  'fastlz:
  type: library
  artifact:
    source:
      type: git
      url: \'https://github.com/ariya/FastLZ.git\'
      rev: master
    metadata:
      license-files: [LICENSE.MIT]
      license: MIT
  headers:
    - fastlz.h
  static-libs@unix:
    - libfastlz.a
' => 
  array (
    'fastlz' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'url' => 'https://github.com/ariya/FastLZ.git',
          'rev' => 'master',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE.MIT',
          ),
          'license' => 'MIT',
        ),
      ),
      'headers' => 
      array (
        0 => 'fastlz.h',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libfastlz.a',
      ),
    ),
  ),
  'freetype:
  type: library
  artifact:
    source:
      type: ghtagtar
      repo: freetype/freetype
      match: VER-2-\\d+-\\d+
    metadata:
      license-files: [LICENSE.TXT]
      license: FTL
  depends:
    - zlib
  suggests:
    - libpng
    - bzip2
    - brotli
  headers@unix:
    - freetype2/freetype/freetype.h
    - freetype2/ft2build.h
  static-libs@unix:
    - libfreetype.a
  static-libs@windows:
    - libfreetype_a.lib
' => 
  array (
    'freetype' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'freetype/freetype',
          'match' => 'VER-2-\\d+-\\d+',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE.TXT',
          ),
          'license' => 'FTL',
        ),
      ),
      'depends' => 
      array (
        0 => 'zlib',
      ),
      'suggests' => 
      array (
        0 => 'libpng',
        1 => 'bzip2',
        2 => 'brotli',
      ),
      'headers@unix' => 
      array (
        0 => 'freetype2/freetype/freetype.h',
        1 => 'freetype2/ft2build.h',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libfreetype.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'libfreetype_a.lib',
      ),
    ),
  ),
  'gettext-win:
  type: library
  artifact:
    source:
      type: git
      url: \'https://github.com/winlibs/gettext.git\'
      rev: \'0.18\'
  static-libs@windows:
    - libintl_a.lib
' => 
  array (
    'gettext-win' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'url' => 'https://github.com/winlibs/gettext.git',
          'rev' => '0.18',
        ),
      ),
      'static-libs@windows' => 
      array (
        0 => 'libintl_a.lib',
      ),
    ),
  ),
  'gettext:
  type: library
  artifact:
    source:
      type: filelist
      url: \'https://ftp.gnu.org/gnu/gettext/\'
      regex: \'/href="(?<file>gettext-(?<version>[^"]+)\\.tar\\.xz)"/\'
    source-mirror:
      type: filelist
      url: \'https://ftpmirror.gnu.org/gnu/gettext/\'
      regex: \'/href="(?<file>gettext-(?<version>[^"]+)\\.tar\\.xz)"/\'
    metadata:
      license-files: [gettext-runtime/intl/COPYING.LIB]
      license: LGPL-2.1-or-later
  depends:
    - libiconv
  suggests:
    - ncurses
    - libxml2
  frameworks:
    - CoreFoundation
  static-libs@unix:
    - libintl.a
' => 
  array (
    'gettext' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'filelist',
          'url' => 'https://ftp.gnu.org/gnu/gettext/',
          'regex' => '/href="(?<file>gettext-(?<version>[^"]+)\\.tar\\.xz)"/',
        ),
        'source-mirror' => 
        array (
          'type' => 'filelist',
          'url' => 'https://ftpmirror.gnu.org/gnu/gettext/',
          'regex' => '/href="(?<file>gettext-(?<version>[^"]+)\\.tar\\.xz)"/',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'gettext-runtime/intl/COPYING.LIB',
          ),
          'license' => 'LGPL-2.1-or-later',
        ),
      ),
      'depends' => 
      array (
        0 => 'libiconv',
      ),
      'suggests' => 
      array (
        0 => 'ncurses',
        1 => 'libxml2',
      ),
      'frameworks' => 
      array (
        0 => 'CoreFoundation',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libintl.a',
      ),
    ),
  ),
  'glfw:
  type: library
  artifact: glfw
  frameworks:
    - Cocoa
    - CoreFoundation
    - CoreVideo
    - IOKit
    - QuartzCore
  headers:
    - GLFW/glfw3.h
    - GLFW/glfw3native.h
  lang: cpp
  static-libs@unix:
    - libglfw3.a
  static-libs@windows:
    - glfw3.lib
' => 
  array (
    'glfw' => 
    array (
      'type' => 'library',
      'artifact' => 'glfw',
      'frameworks' => 
      array (
        0 => 'Cocoa',
        1 => 'CoreFoundation',
        2 => 'CoreVideo',
        3 => 'IOKit',
        4 => 'QuartzCore',
      ),
      'headers' => 
      array (
        0 => 'GLFW/glfw3.h',
        1 => 'GLFW/glfw3native.h',
      ),
      'lang' => 'cpp',
      'static-libs@unix' => 
      array (
        0 => 'libglfw3.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'glfw3.lib',
      ),
    ),
  ),
  'gmp:
  type: library
  artifact:
    source:
      type: filelist
      url: \'https://ftp.gnu.org/gnu/gmp/\'
      regex: \'/href="(?<file>gmp-(?<version>[^"]+)\\.tar\\.xz)"/\'
    source-mirror:
      type: filelist
      url: \'https://ftpmirror.gnu.org/gnu/gmp/\'
      regex: \'/href="(?<file>gmp-(?<version>[^"]+)\\.tar\\.xz)"/\'
    metadata:
      license-files: [\'@/gmp.txt\']
      license: Custom
  headers:
    - gmp.h
  pkg-configs:
    - gmp
  static-libs@unix:
    - libgmp.a
' => 
  array (
    'gmp' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'filelist',
          'url' => 'https://ftp.gnu.org/gnu/gmp/',
          'regex' => '/href="(?<file>gmp-(?<version>[^"]+)\\.tar\\.xz)"/',
        ),
        'source-mirror' => 
        array (
          'type' => 'filelist',
          'url' => 'https://ftpmirror.gnu.org/gnu/gmp/',
          'regex' => '/href="(?<file>gmp-(?<version>[^"]+)\\.tar\\.xz)"/',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => '@/gmp.txt',
          ),
          'license' => 'Custom',
        ),
      ),
      'headers' => 
      array (
        0 => 'gmp.h',
      ),
      'pkg-configs' => 
      array (
        0 => 'gmp',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libgmp.a',
      ),
    ),
  ),
  'gmssl:
  type: library
  artifact:
    source:
      type: git
      url: \'https://github.com/guanzhi/GmSSL.git\'
      rev: master
    metadata:
      license-files: [LICENSE]
      license: Apache-2.0
  frameworks:
    - Security
  static-libs@unix:
    - libgmssl.a
  static-libs@windows:
    - gmssl.lib
' => 
  array (
    'gmssl' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'url' => 'https://github.com/guanzhi/GmSSL.git',
          'rev' => 'master',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'Apache-2.0',
        ),
      ),
      'frameworks' => 
      array (
        0 => 'Security',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libgmssl.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'gmssl.lib',
      ),
    ),
  ),
  'grpc:
  type: library
  artifact:
    source:
      type: git
      rev: v1.75.x
      url: \'https://github.com/grpc/grpc.git\'
    metadata:
      license-files: [LICENSE]
      license: Apache-2.0
  depends:
    - zlib
    - openssl
    - libcares
  frameworks:
    - CoreFoundation
  lang: cpp
  pkg-configs:
    - grpc
' => 
  array (
    'grpc' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'rev' => 'v1.75.x',
          'url' => 'https://github.com/grpc/grpc.git',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'Apache-2.0',
        ),
      ),
      'depends' => 
      array (
        0 => 'zlib',
        1 => 'openssl',
        2 => 'libcares',
      ),
      'frameworks' => 
      array (
        0 => 'CoreFoundation',
      ),
      'lang' => 'cpp',
      'pkg-configs' => 
      array (
        0 => 'grpc',
      ),
    ),
  ),
  'icu:
  type: library
  artifact:
    source:
      type: ghrel
      repo: unicode-org/icu
      match: icu4c.+-src\\.tgz
      prefer-stable: true
    binary:
      windows-x86_64: { type: url, url: \'https://dl.static-php.dev/static-php-cli/deps/icu-static-windows-x64/icu-static-windows-x64.zip\', extract: hosted }
    metadata:
      license-files: [\'@/icu.txt\']
      license: ICU
  headers@windows:
    - unicode
  lang: cpp
  pkg-configs:
    - icu-uc
    - icu-i18n
    - icu-io
  static-libs@windows:
    - icudt.lib
    - icuin.lib
    - icuio.lib
    - icuuc.lib
' => 
  array (
    'icu' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'unicode-org/icu',
          'match' => 'icu4c.+-src\\.tgz',
          'prefer-stable' => true,
        ),
        'binary' => 
        array (
          'windows-x86_64' => 
          array (
            'type' => 'url',
            'url' => 'https://dl.static-php.dev/static-php-cli/deps/icu-static-windows-x64/icu-static-windows-x64.zip',
            'extract' => 'hosted',
          ),
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => '@/icu.txt',
          ),
          'license' => 'ICU',
        ),
      ),
      'headers@windows' => 
      array (
        0 => 'unicode',
      ),
      'lang' => 'cpp',
      'pkg-configs' => 
      array (
        0 => 'icu-uc',
        1 => 'icu-i18n',
        2 => 'icu-io',
      ),
      'static-libs@windows' => 
      array (
        0 => 'icudt.lib',
        1 => 'icuin.lib',
        2 => 'icuio.lib',
        3 => 'icuuc.lib',
      ),
    ),
  ),
  'idn2:
  type: library
  artifact:
    source:
      type: filelist
      url: \'https://ftp.gnu.org/gnu/libidn/\'
      regex: \'/href="(?<file>libidn2-(?<version>[^"]+)\\.tar\\.gz)"/\'
    source-mirror:
      type: filelist
      url: \'https://ftpmirror.gnu.org/gnu/libidn/\'
      regex: \'/href="(?<file>libidn2-(?<version>[^"]+)\\.tar\\.gz)"/\'
    metadata:
      license-files: [COPYING.LESSERv3]
      license: LGPL-3.0-or-later
  depends@macos:
    - libiconv
    - gettext
  suggests@unix:
    - libiconv
    - gettext
    - libunistring
  headers:
    - idn2.h
  pkg-configs:
    - libidn2
' => 
  array (
    'idn2' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'filelist',
          'url' => 'https://ftp.gnu.org/gnu/libidn/',
          'regex' => '/href="(?<file>libidn2-(?<version>[^"]+)\\.tar\\.gz)"/',
        ),
        'source-mirror' => 
        array (
          'type' => 'filelist',
          'url' => 'https://ftpmirror.gnu.org/gnu/libidn/',
          'regex' => '/href="(?<file>libidn2-(?<version>[^"]+)\\.tar\\.gz)"/',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING.LESSERv3',
          ),
          'license' => 'LGPL-3.0-or-later',
        ),
      ),
      'depends@macos' => 
      array (
        0 => 'libiconv',
        1 => 'gettext',
      ),
      'suggests@unix' => 
      array (
        0 => 'libiconv',
        1 => 'gettext',
        2 => 'libunistring',
      ),
      'headers' => 
      array (
        0 => 'idn2.h',
      ),
      'pkg-configs' => 
      array (
        0 => 'libidn2',
      ),
    ),
  ),
  'imagemagick:
  type: library
  artifact:
    source:
      type: ghtar
      repo: ImageMagick/ImageMagick
    metadata:
      license-files: [LICENSE]
  depends:
    - zlib
    - libjpeg
    - libjxl
    - libpng
    - libwebp
    - freetype
    - libtiff
    - libheif
    - bzip2
  depends@windows:
    - zlib
  suggests:
    - zstd
    - xz
    - libzip
    - libxml2
  suggests@unix:
    - lcms2
  headers@windows:
    - imagemagick/MagickWand/MagickWand.h
  lang: cpp
  pkg-configs:
    - Magick++-7.Q16HDRI
    - MagickCore-7.Q16HDRI
    - MagickWand-7.Q16HDRI
  static-libs@windows:
    - CORE_RL_MagickWand_.lib
    - CORE_RL_MagickCore_.lib
    - CORE_RL_coders_.lib
    - CORE_RL_filters_.lib
    - CORE_RL_aom_.lib
    - CORE_RL_brotli_.lib
    - CORE_RL_bzip2_.lib
    - CORE_RL_cairo_.lib
    - CORE_RL_croco_.lib
    - CORE_RL_de265_.lib
    - CORE_RL_exr_.lib
    - CORE_RL_ffi_.lib
    - CORE_RL_freetype_.lib
    - CORE_RL_fribidi_.lib
    - CORE_RL_gdk-pixbuf_.lib
    - CORE_RL_glib_.lib
    - CORE_RL_harfbuzz_.lib
    - CORE_RL_heif_.lib
    - CORE_RL_highway_.lib
    - CORE_RL_imath_.lib
    - CORE_RL_jpeg-turbo-12_.lib
    - CORE_RL_jpeg-turbo-16_.lib
    - CORE_RL_jpeg-turbo_.lib
    - CORE_RL_jpeg-xl_.lib
    - CORE_RL_lcms_.lib
    - CORE_RL_lqr_.lib
    - CORE_RL_lzma_.lib
    - CORE_RL_openh264_.lib
    - CORE_RL_openjpeg_.lib
    - CORE_RL_openjph_.lib
    - CORE_RL_pango_.lib
    - CORE_RL_pixman_.lib
    - CORE_RL_png_.lib
    - CORE_RL_raqm_.lib
    - CORE_RL_raw_.lib
    - CORE_RL_rsvg_.lib
    - CORE_RL_tiff_.lib
    - CORE_RL_webp_.lib
    - CORE_RL_xml_.lib
    - CORE_RL_zip_.lib
    - CORE_RL_zlib_.lib
' => 
  array (
    'imagemagick' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'ImageMagick/ImageMagick',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
        ),
      ),
      'depends' => 
      array (
        0 => 'zlib',
        1 => 'libjpeg',
        2 => 'libjxl',
        3 => 'libpng',
        4 => 'libwebp',
        5 => 'freetype',
        6 => 'libtiff',
        7 => 'libheif',
        8 => 'bzip2',
      ),
      'depends@windows' => 
      array (
        0 => 'zlib',
      ),
      'suggests' => 
      array (
        0 => 'zstd',
        1 => 'xz',
        2 => 'libzip',
        3 => 'libxml2',
      ),
      'suggests@unix' => 
      array (
        0 => 'lcms2',
      ),
      'headers@windows' => 
      array (
        0 => 'imagemagick/MagickWand/MagickWand.h',
      ),
      'lang' => 'cpp',
      'pkg-configs' => 
      array (
        0 => 'Magick++-7.Q16HDRI',
        1 => 'MagickCore-7.Q16HDRI',
        2 => 'MagickWand-7.Q16HDRI',
      ),
      'static-libs@windows' => 
      array (
        0 => 'CORE_RL_MagickWand_.lib',
        1 => 'CORE_RL_MagickCore_.lib',
        2 => 'CORE_RL_coders_.lib',
        3 => 'CORE_RL_filters_.lib',
        4 => 'CORE_RL_aom_.lib',
        5 => 'CORE_RL_brotli_.lib',
        6 => 'CORE_RL_bzip2_.lib',
        7 => 'CORE_RL_cairo_.lib',
        8 => 'CORE_RL_croco_.lib',
        9 => 'CORE_RL_de265_.lib',
        10 => 'CORE_RL_exr_.lib',
        11 => 'CORE_RL_ffi_.lib',
        12 => 'CORE_RL_freetype_.lib',
        13 => 'CORE_RL_fribidi_.lib',
        14 => 'CORE_RL_gdk-pixbuf_.lib',
        15 => 'CORE_RL_glib_.lib',
        16 => 'CORE_RL_harfbuzz_.lib',
        17 => 'CORE_RL_heif_.lib',
        18 => 'CORE_RL_highway_.lib',
        19 => 'CORE_RL_imath_.lib',
        20 => 'CORE_RL_jpeg-turbo-12_.lib',
        21 => 'CORE_RL_jpeg-turbo-16_.lib',
        22 => 'CORE_RL_jpeg-turbo_.lib',
        23 => 'CORE_RL_jpeg-xl_.lib',
        24 => 'CORE_RL_lcms_.lib',
        25 => 'CORE_RL_lqr_.lib',
        26 => 'CORE_RL_lzma_.lib',
        27 => 'CORE_RL_openh264_.lib',
        28 => 'CORE_RL_openjpeg_.lib',
        29 => 'CORE_RL_openjph_.lib',
        30 => 'CORE_RL_pango_.lib',
        31 => 'CORE_RL_pixman_.lib',
        32 => 'CORE_RL_png_.lib',
        33 => 'CORE_RL_raqm_.lib',
        34 => 'CORE_RL_raw_.lib',
        35 => 'CORE_RL_rsvg_.lib',
        36 => 'CORE_RL_tiff_.lib',
        37 => 'CORE_RL_webp_.lib',
        38 => 'CORE_RL_xml_.lib',
        39 => 'CORE_RL_zip_.lib',
        40 => 'CORE_RL_zlib_.lib',
      ),
    ),
  ),
  'imap:
  type: library
  artifact:
    source:
      type: git
      url: \'https://github.com/static-php/imap.git\'
      rev: master
    metadata:
      license-files: [LICENSE]
  suggests@unix:
    - openssl
  static-libs@unix:
    - libc-client.a
' => 
  array (
    'imap' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'url' => 'https://github.com/static-php/imap.git',
          'rev' => 'master',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
        ),
      ),
      'suggests@unix' => 
      array (
        0 => 'openssl',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libc-client.a',
      ),
    ),
  ),
  'jbig:
  type: library
  artifact:
    source: \'https://dl.static-php.dev/static-php-cli/deps/jbig/jbigkit-2.1.tar.gz\'
    source-mirror: \'https://www.cl.cam.ac.uk/~mgk25/jbigkit/download/jbigkit-2.1.tar.gz\'
    metadata:
      license-files: [COPYING]
      license: GPL-2.0-or-later
  headers:
    - jbig.h
    - jbig85.h
    - jbig_ar.h
  static-libs@unix:
    - libjbig.a
    - libjbig85.a
' => 
  array (
    'jbig' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 'https://dl.static-php.dev/static-php-cli/deps/jbig/jbigkit-2.1.tar.gz',
        'source-mirror' => 'https://www.cl.cam.ac.uk/~mgk25/jbigkit/download/jbigkit-2.1.tar.gz',
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'GPL-2.0-or-later',
        ),
      ),
      'headers' => 
      array (
        0 => 'jbig.h',
        1 => 'jbig85.h',
        2 => 'jbig_ar.h',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libjbig.a',
        1 => 'libjbig85.a',
      ),
    ),
  ),
  'krb5:
  type: library
  artifact:
    source:
      type: url
      url: \'https://web.mit.edu/kerberos/dist/krb5/1.22/krb5-1.22.2.tar.gz\'
      source-root: src
    metadata:
      license-files: [NOTICE]
      license: BSD-3-Clause
  depends:
    - openssl
  suggests:
    - ldap
    - libedit
  frameworks:
    - Kerberos
  headers:
    - krb5.h
    - gssapi/gssapi.h
  pkg-configs:
    - krb5-gssapi
' => 
  array (
    'krb5' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'url',
          'url' => 'https://web.mit.edu/kerberos/dist/krb5/1.22/krb5-1.22.2.tar.gz',
          'source-root' => 'src',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'NOTICE',
          ),
          'license' => 'BSD-3-Clause',
        ),
      ),
      'depends' => 
      array (
        0 => 'openssl',
      ),
      'suggests' => 
      array (
        0 => 'ldap',
        1 => 'libedit',
      ),
      'frameworks' => 
      array (
        0 => 'Kerberos',
      ),
      'headers' => 
      array (
        0 => 'krb5.h',
        1 => 'gssapi/gssapi.h',
      ),
      'pkg-configs' => 
      array (
        0 => 'krb5-gssapi',
      ),
    ),
  ),
  'lcms2:
  type: library
  artifact:
    source:
      type: ghtagtar
      repo: mm2/Little-CMS
      match: \'lcms2\\.\\d+(\\.\\d+)?$\'
    metadata:
      license-files: [COPYING]
      license: MIT
  headers@unix:
    - lcms2.h
  pkg-configs:
    - lcms2
  static-libs@unix:
    - liblcms2.a
' => 
  array (
    'lcms2' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'mm2/Little-CMS',
          'match' => 'lcms2\\.\\d+(\\.\\d+)?$',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'MIT',
        ),
      ),
      'headers@unix' => 
      array (
        0 => 'lcms2.h',
      ),
      'pkg-configs' => 
      array (
        0 => 'lcms2',
      ),
      'static-libs@unix' => 
      array (
        0 => 'liblcms2.a',
      ),
    ),
  ),
  'ldap:
  type: library
  artifact:
    source:
      type: filelist
      url: \'https://www.openldap.org/software/download/OpenLDAP/openldap-release/\'
      regex: \'/href="(?<file>openldap-(?<version>[^"]+)\\.tgz)"/\'
    metadata:
      license-files: [LICENSE]
  depends:
    - openssl
    - zlib
    - gmp
    - libsodium
  pkg-configs:
    - ldap
    - lber
' => 
  array (
    'ldap' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'filelist',
          'url' => 'https://www.openldap.org/software/download/OpenLDAP/openldap-release/',
          'regex' => '/href="(?<file>openldap-(?<version>[^"]+)\\.tgz)"/',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
        ),
      ),
      'depends' => 
      array (
        0 => 'openssl',
        1 => 'zlib',
        2 => 'gmp',
        3 => 'libsodium',
      ),
      'pkg-configs' => 
      array (
        0 => 'ldap',
        1 => 'lber',
      ),
    ),
  ),
  'lerc:
  type: library
  artifact:
    source:
      type: ghtar
      repo: Esri/lerc
      prefer-stable: true
    metadata:
      license-files: [LICENSE]
  lang: cpp
  static-libs@unix:
    - libLerc.a
' => 
  array (
    'lerc' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'Esri/lerc',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
        ),
      ),
      'lang' => 'cpp',
      'static-libs@unix' => 
      array (
        0 => 'libLerc.a',
      ),
    ),
  ),
  'libacl:
  type: library
  artifact:
    source: \'https://download.savannah.nongnu.org/releases/acl/acl-2.3.2.tar.gz\'
    source-mirror: \'https://mirror.souseiseki.middlendian.com/nongnu/acl/acl-2.3.2.tar.gz\'
    metadata:
      license-files: [doc/COPYING.LGPL]
      license: LGPL-2.1-or-later
  depends:
    - attr
  static-libs@unix:
    - libacl.a
' => 
  array (
    'libacl' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 'https://download.savannah.nongnu.org/releases/acl/acl-2.3.2.tar.gz',
        'source-mirror' => 'https://mirror.souseiseki.middlendian.com/nongnu/acl/acl-2.3.2.tar.gz',
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'doc/COPYING.LGPL',
          ),
          'license' => 'LGPL-2.1-or-later',
        ),
      ),
      'depends' => 
      array (
        0 => 'attr',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libacl.a',
      ),
    ),
  ),
  'libaom:
  type: library
  artifact:
    source:
      type: git
      rev: main
      url: \'https://aomedia.googlesource.com/aom\'
    metadata:
      license-files: [LICENSE]
  lang: cpp
  static-libs@unix:
    - libaom.a
  static-libs@windows:
    - aom.lib
' => 
  array (
    'libaom' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'rev' => 'main',
          'url' => 'https://aomedia.googlesource.com/aom',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
        ),
      ),
      'lang' => 'cpp',
      'static-libs@unix' => 
      array (
        0 => 'libaom.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'aom.lib',
      ),
    ),
  ),
  'libargon2:
  type: library
  artifact:
    source:
      type: git
      rev: master
      url: \'https://github.com/static-php/phc-winner-argon2\'
    metadata:
      license-files: [LICENSE]
      license: BSD-2-Clause
  suggests:
    - libsodium
  static-libs@unix:
    - libargon2.a
' => 
  array (
    'libargon2' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'rev' => 'master',
          'url' => 'https://github.com/static-php/phc-winner-argon2',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-2-Clause',
        ),
      ),
      'suggests' => 
      array (
        0 => 'libsodium',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libargon2.a',
      ),
    ),
  ),
  'libavif:
  type: library
  artifact:
    source:
      type: ghtar
      repo: AOMediaCodec/libavif
    metadata:
      license-files: [LICENSE]
      license: BSD-2-Clause
  depends:
    - libaom
  suggests:
    - libwebp
    - libjpeg
    - libxml2
    - libpng
  static-libs@unix:
    - libavif.a
  static-libs@windows:
    - avif.lib
' => 
  array (
    'libavif' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'AOMediaCodec/libavif',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-2-Clause',
        ),
      ),
      'depends' => 
      array (
        0 => 'libaom',
      ),
      'suggests' => 
      array (
        0 => 'libwebp',
        1 => 'libjpeg',
        2 => 'libxml2',
        3 => 'libpng',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libavif.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'avif.lib',
      ),
    ),
  ),
  'libcares:
  type: library
  artifact:
    source:
      type: ghrel
      repo: c-ares/c-ares
      match: c-ares-.+\\.tar\\.gz
      prefer-stable: true
    source-mirror:
      type: filelist
      url: \'https://c-ares.org/download/\'
      regex: \'/href="\\/download\\/(?<file>c-ares-(?<version>[^"]+)\\.tar\\.gz)"/\'
    metadata:
      license-files: [LICENSE.md]
  headers@unix:
    - ares.h
    - ares_dns.h
    - ares_nameser.h
  pkg-configs:
    - libcares
  static-libs@unix:
    - libcares.a
' => 
  array (
    'libcares' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'c-ares/c-ares',
          'match' => 'c-ares-.+\\.tar\\.gz',
          'prefer-stable' => true,
        ),
        'source-mirror' => 
        array (
          'type' => 'filelist',
          'url' => 'https://c-ares.org/download/',
          'regex' => '/href="\\/download\\/(?<file>c-ares-(?<version>[^"]+)\\.tar\\.gz)"/',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE.md',
          ),
        ),
      ),
      'headers@unix' => 
      array (
        0 => 'ares.h',
        1 => 'ares_dns.h',
        2 => 'ares_nameser.h',
      ),
      'pkg-configs' => 
      array (
        0 => 'libcares',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libcares.a',
      ),
    ),
  ),
  'libde265:
  type: library
  artifact:
    source:
      type: ghrel
      repo: strukturag/libde265
      match: libde265-.+\\.tar\\.gz
      prefer-stable: true
    metadata:
      license-files: [COPYING]
  lang: cpp
  static-libs@unix:
    - libde265.a
' => 
  array (
    'libde265' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'strukturag/libde265',
          'match' => 'libde265-.+\\.tar\\.gz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
        ),
      ),
      'lang' => 'cpp',
      'static-libs@unix' => 
      array (
        0 => 'libde265.a',
      ),
    ),
  ),
  'libedit:
  type: library
  artifact:
    source:
      type: filelist
      url: \'https://thrysoee.dk/editline/\'
      regex: \'/href="(?<file>libedit-(?<version>[^"]+)\\.tar\\.gz)"/\'
    metadata:
      license-files: [COPYING]
      license: BSD-3-Clause
  depends:
    - ncurses
  static-libs@unix:
    - libedit.a
' => 
  array (
    'libedit' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'filelist',
          'url' => 'https://thrysoee.dk/editline/',
          'regex' => '/href="(?<file>libedit-(?<version>[^"]+)\\.tar\\.gz)"/',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'BSD-3-Clause',
        ),
      ),
      'depends' => 
      array (
        0 => 'ncurses',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libedit.a',
      ),
    ),
  ),
  'libevent:
  type: library
  artifact:
    source:
      type: ghrel
      repo: libevent/libevent
      match: libevent.+\\.tar\\.gz
      prefer-stable: true
    metadata:
      license-files: [LICENSE]
      license: BSD-3-Clause
  depends@unix:
    - openssl
  static-libs@unix:
    - libevent.a
    - libevent_core.a
    - libevent_extra.a
    - libevent_openssl.a
    - libevent_pthreads.a
' => 
  array (
    'libevent' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'libevent/libevent',
          'match' => 'libevent.+\\.tar\\.gz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-3-Clause',
        ),
      ),
      'depends@unix' => 
      array (
        0 => 'openssl',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libevent.a',
        1 => 'libevent_core.a',
        2 => 'libevent_extra.a',
        3 => 'libevent_openssl.a',
        4 => 'libevent_pthreads.a',
      ),
    ),
  ),
  'libffi-win:
  type: library
  artifact:
    source:
      type: git
      rev: master
      url: \'https://github.com/static-php/libffi-win.git\'
    metadata:
      license-files: [LICENSE]
      license: MIT
  static-libs@windows:
    - libffi.lib
' => 
  array (
    'libffi-win' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'rev' => 'master',
          'url' => 'https://github.com/static-php/libffi-win.git',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'MIT',
        ),
      ),
      'static-libs@windows' => 
      array (
        0 => 'libffi.lib',
      ),
    ),
  ),
  'libffi:
  type: library
  artifact:
    source:
      type: ghrel
      repo: libffi/libffi
      match: libffi.+\\.tar\\.gz
      prefer-stable: true
    metadata:
      license-files: [LICENSE]
      license: MIT
  headers@unix:
    - ffi.h
    - ffitarget.h
  static-libs@unix:
    - libffi.a
' => 
  array (
    'libffi' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'libffi/libffi',
          'match' => 'libffi.+\\.tar\\.gz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'MIT',
        ),
      ),
      'headers@unix' => 
      array (
        0 => 'ffi.h',
        1 => 'ffitarget.h',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libffi.a',
      ),
    ),
  ),
  'libgearman:
  type: library
  artifact:
    source:
      type: ghrel
      repo: gearman/gearmand
      match: gearmand-.+\\.tar\\.gz
      prefer-stable: true
    metadata:
      license-files: [COPYING]
      license: BSD-3-Clause
  depends:
    - libevent
    - libuuid
  suggests:
    - libmemcached
  headers@unix:
    - libgearman-1.0/gearman.h
  lang: cpp
  pkg-configs:
    - gearmand
  static-libs@unix:
    - libgearman.a
' => 
  array (
    'libgearman' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'gearman/gearmand',
          'match' => 'gearmand-.+\\.tar\\.gz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'BSD-3-Clause',
        ),
      ),
      'depends' => 
      array (
        0 => 'libevent',
        1 => 'libuuid',
      ),
      'suggests' => 
      array (
        0 => 'libmemcached',
      ),
      'headers@unix' => 
      array (
        0 => 'libgearman-1.0/gearman.h',
      ),
      'lang' => 'cpp',
      'pkg-configs' => 
      array (
        0 => 'gearmand',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libgearman.a',
      ),
    ),
  ),
  'libheif:
  type: library
  artifact:
    source:
      type: ghrel
      repo: strukturag/libheif
      match: libheif-.+\\.tar\\.gz
      prefer-stable: true
    metadata:
      license-files: [COPYING]
  depends:
    - libde265
    - libwebp
    - libaom
    - zlib
    - brotli
  static-libs@unix:
    - libheif.a
' => 
  array (
    'libheif' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'strukturag/libheif',
          'match' => 'libheif-.+\\.tar\\.gz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
        ),
      ),
      'depends' => 
      array (
        0 => 'libde265',
        1 => 'libwebp',
        2 => 'libaom',
        3 => 'zlib',
        4 => 'brotli',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libheif.a',
      ),
    ),
  ),
  'libiconv-win:
  type: library
  artifact:
    source:
      type: git
      rev: master
      url: \'https://github.com/static-php/libiconv-win.git\'
    metadata:
      license-files: [source/COPYING]
      license: GPL-3.0-or-later
  static-libs@windows:
    - libiconv_a.lib
' => 
  array (
    'libiconv-win' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'rev' => 'master',
          'url' => 'https://github.com/static-php/libiconv-win.git',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'source/COPYING',
          ),
          'license' => 'GPL-3.0-or-later',
        ),
      ),
      'static-libs@windows' => 
      array (
        0 => 'libiconv_a.lib',
      ),
    ),
  ),
  'libiconv:
  type: library
  artifact:
    source:
      type: filelist
      url: \'https://ftp.gnu.org/gnu/libiconv/\'
      regex: \'/href="(?<file>libiconv-(?<version>[^"]+)\\.tar\\.gz)"/\'
    source-mirror:
      type: filelist
      url: \'https://ftpmirror.gnu.org/gnu/libiconv/\'
      regex: \'/href="(?<file>libiconv-(?<version>[^"]+)\\.tar\\.gz)"/\'
    metadata:
      license-files: [COPYING.LIB]
      license: LGPL-2.0-or-later
  headers:
    - iconv.h
    - libcharset.h
    - localcharset.h
  static-libs@unix:
    - libiconv.a
    - libcharset.a
' => 
  array (
    'libiconv' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'filelist',
          'url' => 'https://ftp.gnu.org/gnu/libiconv/',
          'regex' => '/href="(?<file>libiconv-(?<version>[^"]+)\\.tar\\.gz)"/',
        ),
        'source-mirror' => 
        array (
          'type' => 'filelist',
          'url' => 'https://ftpmirror.gnu.org/gnu/libiconv/',
          'regex' => '/href="(?<file>libiconv-(?<version>[^"]+)\\.tar\\.gz)"/',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING.LIB',
          ),
          'license' => 'LGPL-2.0-or-later',
        ),
      ),
      'headers' => 
      array (
        0 => 'iconv.h',
        1 => 'libcharset.h',
        2 => 'localcharset.h',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libiconv.a',
        1 => 'libcharset.a',
      ),
    ),
  ),
  'libjpeg:
  type: library
  artifact:
    source:
      type: ghtar
      repo: libjpeg-turbo/libjpeg-turbo
    metadata:
      license-files: [LICENSE.md]
      license: IJG
  suggests@windows:
    - zlib
  static-libs@unix:
    - libjpeg.a
    - libturbojpeg.a
  static-libs@windows:
    - libjpeg_a.lib
' => 
  array (
    'libjpeg' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'libjpeg-turbo/libjpeg-turbo',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE.md',
          ),
          'license' => 'IJG',
        ),
      ),
      'suggests@windows' => 
      array (
        0 => 'zlib',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libjpeg.a',
        1 => 'libturbojpeg.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'libjpeg_a.lib',
      ),
    ),
  ),
  'libjxl:
  type: library
  artifact:
    source:
      type: git
      url: \'https://github.com/libjxl/libjxl\'
      rev: main
      submodules: [third_party/highway, third_party/libjpeg-turbo, third_party/sjpeg, third_party/skcms]
    metadata:
      license-files: [LICENSE]
      license: BSD-3-Clause
  depends:
    - brotli
    - libjpeg
    - libpng
    - libwebp
  pkg-configs:
    - libjxl
    - libjxl_cms
    - libjxl_threads
    - libhwy
' => 
  array (
    'libjxl' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'url' => 'https://github.com/libjxl/libjxl',
          'rev' => 'main',
          'submodules' => 
          array (
            0 => 'third_party/highway',
            1 => 'third_party/libjpeg-turbo',
            2 => 'third_party/sjpeg',
            3 => 'third_party/skcms',
          ),
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-3-Clause',
        ),
      ),
      'depends' => 
      array (
        0 => 'brotli',
        1 => 'libjpeg',
        2 => 'libpng',
        3 => 'libwebp',
      ),
      'pkg-configs' => 
      array (
        0 => 'libjxl',
        1 => 'libjxl_cms',
        2 => 'libjxl_threads',
        3 => 'libhwy',
      ),
    ),
  ),
  'liblz4:
  type: library
  artifact:
    source:
      type: ghrel
      repo: lz4/lz4
      match: lz4-.+\\.tar\\.gz
      prefer-stable: true
    metadata:
      license-files: [LICENSE]
      license: BSD-2-Clause
  static-libs@unix:
    - liblz4.a
  static-libs@windows:
    - lz4.lib
' => 
  array (
    'liblz4' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'lz4/lz4',
          'match' => 'lz4-.+\\.tar\\.gz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-2-Clause',
        ),
      ),
      'static-libs@unix' => 
      array (
        0 => 'liblz4.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'lz4.lib',
      ),
    ),
  ),
  'libmaxminddb:
  type: library
  artifact:
    source:
      type: ghrel
      repo: maxmind/libmaxminddb
      match: libmaxminddb-.+\\.tar\\.gz
      prefer-stable: true
    metadata:
      license-files: [LICENSE]
      license: Apache-2.0
  headers:
    - maxminddb.h
    - maxminddb_config.h
  static-libs@unix:
    - libmaxminddb.a
  static-libs@windows:
    - libmaxminddb.lib
' => 
  array (
    'libmaxminddb' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'maxmind/libmaxminddb',
          'match' => 'libmaxminddb-.+\\.tar\\.gz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'Apache-2.0',
        ),
      ),
      'headers' => 
      array (
        0 => 'maxminddb.h',
        1 => 'maxminddb_config.h',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libmaxminddb.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'libmaxminddb.lib',
      ),
    ),
  ),
  'libmemcached:
  type: library
  artifact:
    source:
      type: ghtagtar
      repo: awesomized/libmemcached
      match: 1.\\d.\\d
    metadata:
      license-files: [LICENSE]
      license: BSD-3-Clause
  lang: cpp
  static-libs@unix:
    - libmemcached.a
    - libmemcachedprotocol.a
    - libmemcachedutil.a
    - libhashkit.a
' => 
  array (
    'libmemcached' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'awesomized/libmemcached',
          'match' => '1.\\d.\\d',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-3-Clause',
        ),
      ),
      'lang' => 'cpp',
      'static-libs@unix' => 
      array (
        0 => 'libmemcached.a',
        1 => 'libmemcachedprotocol.a',
        2 => 'libmemcachedutil.a',
        3 => 'libhashkit.a',
      ),
    ),
  ),
  'libmpdec:
  type: library
  artifact:
    source:
      type: url
      url: \'https://www.bytereef.org/software/mpdecimal/releases/mpdecimal-4.0.1.tar.gz\'
    metadata:
      license-files: [COPYRIGHT.txt]
      license: BSD-2-Clause
  headers:
    - mpdecimal.h
  static-libs@unix:
    - libmpdec.a
  static-libs@windows:
    - libmpdec_a.lib
' => 
  array (
    'libmpdec' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'url',
          'url' => 'https://www.bytereef.org/software/mpdecimal/releases/mpdecimal-4.0.1.tar.gz',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYRIGHT.txt',
          ),
          'license' => 'BSD-2-Clause',
        ),
      ),
      'headers' => 
      array (
        0 => 'mpdecimal.h',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libmpdec.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'libmpdec_a.lib',
      ),
    ),
  ),
  'libpng:
  type: library
  artifact:
    source:
      type: ghtagtar
      repo: pnggroup/libpng
      match: v1\\.6\\.\\d+
      query: \'?per_page=150\'
    metadata:
      license-files: [LICENSE]
      license: PNG
  depends:
    - zlib
  static-libs@unix:
    - libpng16.a
  static-libs@windows:
    - libpng16_static.lib
    - libpng_a.lib
' => 
  array (
    'libpng' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'pnggroup/libpng',
          'match' => 'v1\\.6\\.\\d+',
          'query' => '?per_page=150',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PNG',
        ),
      ),
      'depends' => 
      array (
        0 => 'zlib',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libpng16.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'libpng16_static.lib',
        1 => 'libpng_a.lib',
      ),
    ),
  ),
  'librabbitmq:
  type: library
  artifact:
    source:
      type: ghtar
      repo: alanxz/rabbitmq-c
      prefer-stable: true
    metadata:
      license-files: [LICENSE]
      license: MIT
  depends:
    - openssl
  static-libs@unix:
    - librabbitmq.a
  static-libs@windows:
    - rabbitmq.4.lib
' => 
  array (
    'librabbitmq' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'alanxz/rabbitmq-c',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'MIT',
        ),
      ),
      'depends' => 
      array (
        0 => 'openssl',
      ),
      'static-libs@unix' => 
      array (
        0 => 'librabbitmq.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'rabbitmq.4.lib',
      ),
    ),
  ),
  'librdkafka:
  type: library
  artifact:
    source:
      type: ghtar
      repo: confluentinc/librdkafka
    source-mirror:
      type: url
      url: \'https://github.com/confluentinc/librdkafka/archive/refs/tags/v2.16.0.tar.gz\'
      filename: librdkafka-2.16.0.tar.gz
      version: 2.16.0
    metadata:
      license-files: [LICENSE]
      license: BSD-2-Clause
  suggests:
    - curl
    - liblz4
    - openssl
    - zlib
    - zstd
  lang: cpp
  pkg-configs:
    - rdkafka++-static
    - rdkafka-static
' => 
  array (
    'librdkafka' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'confluentinc/librdkafka',
        ),
        'source-mirror' => 
        array (
          'type' => 'url',
          'url' => 'https://github.com/confluentinc/librdkafka/archive/refs/tags/v2.16.0.tar.gz',
          'filename' => 'librdkafka-2.16.0.tar.gz',
          'version' => '2.16.0',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-2-Clause',
        ),
      ),
      'suggests' => 
      array (
        0 => 'curl',
        1 => 'liblz4',
        2 => 'openssl',
        3 => 'zlib',
        4 => 'zstd',
      ),
      'lang' => 'cpp',
      'pkg-configs' => 
      array (
        0 => 'rdkafka++-static',
        1 => 'rdkafka-static',
      ),
    ),
  ),
  'libsodium:
  type: library
  artifact:
    source:
      type: ghrel
      repo: jedisct1/libsodium
      match: \'libsodium-(?!1\\.0\\.21)\\d+(\\.\\d+)*\\.tar\\.gz\'
      prefer-stable: true
    metadata:
      license-files: [LICENSE]
  pkg-configs:
    - libsodium
  static-libs@unix:
    - libsodium.a
  static-libs@windows:
    - libsodium.lib
' => 
  array (
    'libsodium' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'jedisct1/libsodium',
          'match' => 'libsodium-(?!1\\.0\\.21)\\d+(\\.\\d+)*\\.tar\\.gz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
        ),
      ),
      'pkg-configs' => 
      array (
        0 => 'libsodium',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libsodium.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'libsodium.lib',
      ),
    ),
  ),
  'libssh2:
  type: library
  artifact:
    source:
      type: ghrel
      repo: libssh2/libssh2
      match: libssh2.+\\.tar\\.gz
      prefer-stable: true
    metadata:
      license-files: [COPYING]
      license: BSD-3-Clause
  depends@unix:
    - openssl
  depends@windows:
    - zlib
  headers:
    - libssh2.h
    - libssh2_publickey.h
    - libssh2_sftp.h
  pkg-configs:
    - libssh2
  static-libs@unix:
    - libssh2.a
  static-libs@windows:
    - libssh2.lib
' => 
  array (
    'libssh2' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'libssh2/libssh2',
          'match' => 'libssh2.+\\.tar\\.gz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'BSD-3-Clause',
        ),
      ),
      'depends@unix' => 
      array (
        0 => 'openssl',
      ),
      'depends@windows' => 
      array (
        0 => 'zlib',
      ),
      'headers' => 
      array (
        0 => 'libssh2.h',
        1 => 'libssh2_publickey.h',
        2 => 'libssh2_sftp.h',
      ),
      'pkg-configs' => 
      array (
        0 => 'libssh2',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libssh2.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'libssh2.lib',
      ),
    ),
  ),
  'libtiff:
  type: library
  artifact:
    source:
      type: filelist
      url: \'https://download.osgeo.org/libtiff/\'
      regex: \'/href="(?<file>tiff-(?<version>[^"]+)\\.tar\\.xz)"/\'
    metadata:
      license-files: [LICENSE.md]
      license: libtiff
  depends:
    - zlib
    - libjpeg
  suggests@unix:
    - lerc
    - libwebp
    - jbig
    - xz
    - zstd
  static-libs@unix:
    - libtiff.a
' => 
  array (
    'libtiff' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'filelist',
          'url' => 'https://download.osgeo.org/libtiff/',
          'regex' => '/href="(?<file>tiff-(?<version>[^"]+)\\.tar\\.xz)"/',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE.md',
          ),
          'license' => 'libtiff',
        ),
      ),
      'depends' => 
      array (
        0 => 'zlib',
        1 => 'libjpeg',
      ),
      'suggests@unix' => 
      array (
        0 => 'lerc',
        1 => 'libwebp',
        2 => 'jbig',
        3 => 'xz',
        4 => 'zstd',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libtiff.a',
      ),
    ),
  ),
  'libunistring:
  type: library
  artifact:
    source:
      type: filelist
      url: \'https://ftp.gnu.org/gnu/libunistring/\'
      regex: \'/href="(?<file>libunistring-(?<version>[^"]+)\\.tar\\.gz)"/\'
    source-mirror:
      type: filelist
      url: \'https://ftpmirror.gnu.org/gnu/libunistring/\'
      regex: \'/href="(?<file>libunistring-(?<version>[^"]+)\\.tar\\.gz)"/\'
    metadata:
      license-files: [COPYING.LIB]
      license: LGPL-3.0-or-later
  headers:
    - unistr.h
    - unistring/
  static-libs@unix:
    - libunistring.a
' => 
  array (
    'libunistring' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'filelist',
          'url' => 'https://ftp.gnu.org/gnu/libunistring/',
          'regex' => '/href="(?<file>libunistring-(?<version>[^"]+)\\.tar\\.gz)"/',
        ),
        'source-mirror' => 
        array (
          'type' => 'filelist',
          'url' => 'https://ftpmirror.gnu.org/gnu/libunistring/',
          'regex' => '/href="(?<file>libunistring-(?<version>[^"]+)\\.tar\\.gz)"/',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING.LIB',
          ),
          'license' => 'LGPL-3.0-or-later',
        ),
      ),
      'headers' => 
      array (
        0 => 'unistr.h',
        1 => 'unistring/',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libunistring.a',
      ),
    ),
  ),
  'liburing:
  type: library
  artifact:
    source:
      type: ghtar
      repo: axboe/liburing
      prefer-stable: true
    metadata:
      license-files: [COPYING]
      license: LGPL-2.1-or-later
  headers@linux:
    - liburing/
    - liburing.h
  pkg-configs:
    - liburing
    - liburing-ffi
  static-libs@linux:
    - liburing.a
    - liburing-ffi.a
' => 
  array (
    'liburing' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'axboe/liburing',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'LGPL-2.1-or-later',
        ),
      ),
      'headers@linux' => 
      array (
        0 => 'liburing/',
        1 => 'liburing.h',
      ),
      'pkg-configs' => 
      array (
        0 => 'liburing',
        1 => 'liburing-ffi',
      ),
      'static-libs@linux' => 
      array (
        0 => 'liburing.a',
        1 => 'liburing-ffi.a',
      ),
    ),
  ),
  'libuuid:
  type: library
  artifact:
    source:
      type: git
      url: \'https://github.com/static-php/libuuid.git\'
      rev: master
    metadata:
      license-files: [COPYING]
      license: MIT
  headers:
    - uuid/uuid.h
  static-libs@unix:
    - libuuid.a
' => 
  array (
    'libuuid' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'url' => 'https://github.com/static-php/libuuid.git',
          'rev' => 'master',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'MIT',
        ),
      ),
      'headers' => 
      array (
        0 => 'uuid/uuid.h',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libuuid.a',
      ),
    ),
  ),
  'libuv:
  type: library
  artifact:
    source:
      type: ghtar
      repo: libuv/libuv
    metadata:
      license-files: [LICENSE, LICENSE-extra]
      license: MIT
  static-libs@unix:
    - libuv.a
  static-libs@windows:
    - libuv.lib
' => 
  array (
    'libuv' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'libuv/libuv',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
            1 => 'LICENSE-extra',
          ),
          'license' => 'MIT',
        ),
      ),
      'static-libs@unix' => 
      array (
        0 => 'libuv.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'libuv.lib',
      ),
    ),
  ),
  'libwebp:
  type: library
  artifact:
    source:
      type: ghtagtar
      repo: webmproject/libwebp
      match: v1\\.\\d+\\.\\d+$
    metadata:
      license-files: [COPYING]
      license: BSD-3-Clause
  pkg-configs:
    - libwebp
    - libwebpdecoder
    - libwebpdemux
    - libwebpmux
    - libsharpyuv
  static-libs@windows:
    - libwebp.lib
    - libwebpdecoder.lib
    - libwebpdemux.lib
    - libwebpmux.lib
    - libsharpyuv.lib
' => 
  array (
    'libwebp' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'webmproject/libwebp',
          'match' => 'v1\\.\\d+\\.\\d+$',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'BSD-3-Clause',
        ),
      ),
      'pkg-configs' => 
      array (
        0 => 'libwebp',
        1 => 'libwebpdecoder',
        2 => 'libwebpdemux',
        3 => 'libwebpmux',
        4 => 'libsharpyuv',
      ),
      'static-libs@windows' => 
      array (
        0 => 'libwebp.lib',
        1 => 'libwebpdecoder.lib',
        2 => 'libwebpdemux.lib',
        3 => 'libwebpmux.lib',
        4 => 'libsharpyuv.lib',
      ),
    ),
  ),
  'libxml2:
  type: library
  artifact:
    source:
      type: ghtagtar
      repo: GNOME/libxml2
      match: v2\\.\\d+\\.\\d+$
    metadata:
      license-files: [Copyright]
      license: MIT
  depends@unix:
    - libiconv
    - zlib
    - xz
  depends@windows:
    - zlib
    - libiconv-win
  headers:
    - libxml2
  pkg-configs:
    - libxml-2.0
  static-libs@windows:
    - libxml2s.lib
    - libxml2_a.lib
' => 
  array (
    'libxml2' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'GNOME/libxml2',
          'match' => 'v2\\.\\d+\\.\\d+$',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'Copyright',
          ),
          'license' => 'MIT',
        ),
      ),
      'depends@unix' => 
      array (
        0 => 'libiconv',
        1 => 'zlib',
        2 => 'xz',
      ),
      'depends@windows' => 
      array (
        0 => 'zlib',
        1 => 'libiconv-win',
      ),
      'headers' => 
      array (
        0 => 'libxml2',
      ),
      'pkg-configs' => 
      array (
        0 => 'libxml-2.0',
      ),
      'static-libs@windows' => 
      array (
        0 => 'libxml2s.lib',
        1 => 'libxml2_a.lib',
      ),
    ),
  ),
  'libxslt:
  type: library
  artifact:
    source:
      type: filelist
      url: \'https://download.gnome.org/sources/libxslt/1.1/\'
      regex: \'/href="(?<file>libxslt-(?<version>[^"]+)\\.tar\\.xz)"/\'
    metadata:
      license-files: [Copyright]
      license: MIT
  depends:
    - libxml2
  static-libs@unix:
    - libxslt.a
    - libexslt.a
  static-libs@windows:
    - libxslt_a.lib
    - libexslt_a.lib
' => 
  array (
    'libxslt' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'filelist',
          'url' => 'https://download.gnome.org/sources/libxslt/1.1/',
          'regex' => '/href="(?<file>libxslt-(?<version>[^"]+)\\.tar\\.xz)"/',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'Copyright',
          ),
          'license' => 'MIT',
        ),
      ),
      'depends' => 
      array (
        0 => 'libxml2',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libxslt.a',
        1 => 'libexslt.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'libxslt_a.lib',
        1 => 'libexslt_a.lib',
      ),
    ),
  ),
  'libyaml:
  type: library
  artifact:
    source:
      type: ghrel
      repo: yaml/libyaml
      match: yaml-.+\\.tar\\.gz
      prefer-stable: true
    metadata:
      license-files: [License]
      license: MIT
  headers:
    - yaml.h
  static-libs@unix:
    - libyaml.a
  static-libs@windows:
    - yaml.lib
' => 
  array (
    'libyaml' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'yaml/libyaml',
          'match' => 'yaml-.+\\.tar\\.gz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'License',
          ),
          'license' => 'MIT',
        ),
      ),
      'headers' => 
      array (
        0 => 'yaml.h',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libyaml.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'yaml.lib',
      ),
    ),
  ),
  'libzip:
  type: library
  artifact:
    source:
      type: ghrel
      repo: nih-at/libzip
      match: libzip.+\\.tar\\.xz
      prefer-stable: true
    metadata:
      license-files: [LICENSE]
      license: BSD-3-Clause
  depends:
    - zlib
  depends@windows:
    - zlib
    - bzip2
    - xz
  suggests:
    - bzip2
    - xz
    - zstd
    - openssl
  headers:
    - zip.h
    - zipconf.h
  static-libs@unix:
    - libzip.a
  static-libs@windows:
    - libzip_a.lib
' => 
  array (
    'libzip' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'nih-at/libzip',
          'match' => 'libzip.+\\.tar\\.xz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-3-Clause',
        ),
      ),
      'depends' => 
      array (
        0 => 'zlib',
      ),
      'depends@windows' => 
      array (
        0 => 'zlib',
        1 => 'bzip2',
        2 => 'xz',
      ),
      'suggests' => 
      array (
        0 => 'bzip2',
        1 => 'xz',
        2 => 'zstd',
        3 => 'openssl',
      ),
      'headers' => 
      array (
        0 => 'zip.h',
        1 => 'zipconf.h',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libzip.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'libzip_a.lib',
      ),
    ),
  ),
  'mimalloc:
  type: library
  artifact:
    source:
      type: ghtagtar
      repo: microsoft/mimalloc
      match: v3\\.\\d+\\.\\d+$
      query: \'?per_page=100\'
    metadata:
      license-files: [LICENSE]
      license: MIT
  static-libs@unix:
    - libmimalloc.a
' => 
  array (
    'mimalloc' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'microsoft/mimalloc',
          'match' => 'v3\\.\\d+\\.\\d+$',
          'query' => '?per_page=100',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'MIT',
        ),
      ),
      'static-libs@unix' => 
      array (
        0 => 'libmimalloc.a',
      ),
    ),
  ),
  'mpir:
  type: library
  artifact:
    source:
      type: git
      url: \'https://github.com/winlibs/mpir.git\'
      rev: master
  static-libs@windows:
    - mpir_a.lib
' => 
  array (
    'mpir' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'url' => 'https://github.com/winlibs/mpir.git',
          'rev' => 'master',
        ),
      ),
      'static-libs@windows' => 
      array (
        0 => 'mpir_a.lib',
      ),
    ),
  ),
  'ncurses:
  type: library
  artifact: ncurses
  static-libs@unix:
    - libncurses.a
ncursesw:
  type: library
  artifact: ncurses
  static-libs@unix:
    - libncursesw.a
' => 
  array (
    'ncurses' => 
    array (
      'type' => 'library',
      'artifact' => 'ncurses',
      'static-libs@unix' => 
      array (
        0 => 'libncurses.a',
      ),
    ),
    'ncursesw' => 
    array (
      'type' => 'library',
      'artifact' => 'ncurses',
      'static-libs@unix' => 
      array (
        0 => 'libncursesw.a',
      ),
    ),
  ),
  'net-snmp:
  type: library
  artifact:
    source:
      type: ghtagtar
      repo: net-snmp/net-snmp
    metadata:
      license-files: [COPYING]
      license: \'BSD-3-Clause AND MIT\'
  depends:
    - openssl
    - zlib
  pkg-configs:
    - netsnmp
    - netsnmp-agent
' => 
  array (
    'net-snmp' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'net-snmp/net-snmp',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'BSD-3-Clause AND MIT',
        ),
      ),
      'depends' => 
      array (
        0 => 'openssl',
        1 => 'zlib',
      ),
      'pkg-configs' => 
      array (
        0 => 'netsnmp',
        1 => 'netsnmp-agent',
      ),
    ),
  ),
  'nghttp2:
  type: library
  artifact:
    source:
      type: ghrel
      repo: nghttp2/nghttp2
      match: nghttp2.+\\.tar\\.xz
      prefer-stable: true
    metadata:
      license-files: [COPYING]
  depends:
    - zlib
    - openssl
  suggests:
    - libxml2
    - nghttp3
    - ngtcp2
    - brotli
  headers:
    - nghttp2
  pkg-configs:
    - libnghttp2
  static-libs@unix:
    - libnghttp2.a
  static-libs@windows:
    - nghttp2.lib
' => 
  array (
    'nghttp2' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'nghttp2/nghttp2',
          'match' => 'nghttp2.+\\.tar\\.xz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
        ),
      ),
      'depends' => 
      array (
        0 => 'zlib',
        1 => 'openssl',
      ),
      'suggests' => 
      array (
        0 => 'libxml2',
        1 => 'nghttp3',
        2 => 'ngtcp2',
        3 => 'brotli',
      ),
      'headers' => 
      array (
        0 => 'nghttp2',
      ),
      'pkg-configs' => 
      array (
        0 => 'libnghttp2',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libnghttp2.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'nghttp2.lib',
      ),
    ),
  ),
  'nghttp3:
  type: library
  artifact:
    source:
      type: ghrel
      repo: ngtcp2/nghttp3
      match: nghttp3.+\\.tar\\.xz
      prefer-stable: true
    metadata:
      license-files: [COPYING]
      license: MIT
  depends:
    - openssl
  headers:
    - nghttp3
  pkg-configs:
    - libnghttp3
  static-libs@unix:
    - libnghttp3.a
  static-libs@windows:
    - nghttp3.lib
' => 
  array (
    'nghttp3' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'ngtcp2/nghttp3',
          'match' => 'nghttp3.+\\.tar\\.xz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'MIT',
        ),
      ),
      'depends' => 
      array (
        0 => 'openssl',
      ),
      'headers' => 
      array (
        0 => 'nghttp3',
      ),
      'pkg-configs' => 
      array (
        0 => 'libnghttp3',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libnghttp3.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'nghttp3.lib',
      ),
    ),
  ),
  'ngtcp2:
  type: library
  artifact:
    source:
      type: ghrel
      repo: ngtcp2/ngtcp2
      match: ngtcp2.+\\.tar\\.xz
      prefer-stable: true
    metadata:
      license-files: [COPYING]
      license: MIT
  depends:
    - openssl
  headers:
    - ngtcp2
  pkg-configs:
    - libngtcp2
    - libngtcp2_crypto_ossl
  static-libs@unix:
    - libngtcp2.a
    - libngtcp2_crypto_ossl.a
  static-libs@windows:
    - ngtcp2.lib
' => 
  array (
    'ngtcp2' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'ngtcp2/ngtcp2',
          'match' => 'ngtcp2.+\\.tar\\.xz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'MIT',
        ),
      ),
      'depends' => 
      array (
        0 => 'openssl',
      ),
      'headers' => 
      array (
        0 => 'ngtcp2',
      ),
      'pkg-configs' => 
      array (
        0 => 'libngtcp2',
        1 => 'libngtcp2_crypto_ossl',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libngtcp2.a',
        1 => 'libngtcp2_crypto_ossl.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'ngtcp2.lib',
      ),
    ),
  ),
  'onig:
  type: library
  artifact:
    source:
      type: ghrel
      repo: kkos/oniguruma
      match: onig-.+\\.tar\\.gz
    metadata:
      license-files: [COPYING]
      license: Custom
  headers:
    - oniggnu.h
    - oniguruma.h
  static-libs@unix:
    - libonig.a
  static-libs@windows:
    - onig.lib
    - onig_a.lib
' => 
  array (
    'onig' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'kkos/oniguruma',
          'match' => 'onig-.+\\.tar\\.gz',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'Custom',
        ),
      ),
      'headers' => 
      array (
        0 => 'oniggnu.h',
        1 => 'oniguruma.h',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libonig.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'onig.lib',
        1 => 'onig_a.lib',
      ),
    ),
  ),
  'openssl:
  type: library
  artifact:
    source:
      type: ghrel
      repo: openssl/openssl
      match: openssl-3.+\\.tar\\.gz
      prefer-stable: true
    source-mirror:
      type: filelist
      url: \'https://www.openssl.org/source/\'
      regex: \'/href="(?<file>openssl-(?<version>3\\.[^"]+)\\.tar\\.gz)"/\'
    metadata:
      license-files: [LICENSE.txt]
      license: OpenSSL
  depends:
    - zlib
  depends@windows:
    - zlib
  headers:
    - openssl
  static-libs@unix:
    - libssl.a
    - libcrypto.a
  static-libs@windows:
    - libssl.lib
    - libcrypto.lib
  tools@windows:
    - jom
    - nasm
    - strawberry-perl
' => 
  array (
    'openssl' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'openssl/openssl',
          'match' => 'openssl-3.+\\.tar\\.gz',
          'prefer-stable' => true,
        ),
        'source-mirror' => 
        array (
          'type' => 'filelist',
          'url' => 'https://www.openssl.org/source/',
          'regex' => '/href="(?<file>openssl-(?<version>3\\.[^"]+)\\.tar\\.gz)"/',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE.txt',
          ),
          'license' => 'OpenSSL',
        ),
      ),
      'depends' => 
      array (
        0 => 'zlib',
      ),
      'depends@windows' => 
      array (
        0 => 'zlib',
      ),
      'headers' => 
      array (
        0 => 'openssl',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libssl.a',
        1 => 'libcrypto.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'libssl.lib',
        1 => 'libcrypto.lib',
      ),
      'tools@windows' => 
      array (
        0 => 'jom',
        1 => 'nasm',
        2 => 'strawberry-perl',
      ),
    ),
  ),
  'postgresql:
  type: library
  artifact:
    source:
      type: ghtagtar
      repo: postgres/postgres
      match: REL_18_\\d+
    metadata:
      license-files: [\'@/postgresql.txt\']
      license: PostgreSQL
  depends@unix:
    - libiconv
    - libxml2
    - openssl
    - zlib
    - libedit
  depends@windows:
    - openssl
    - zlib
  suggests@unix:
    - icu
    - libxslt
    - ldap
    - zstd
  pkg-configs:
    - libpq
  static-libs@windows:
    - libpq.lib
    - libpgport.lib
    - libpgcommon.lib
  tools@windows:
    - python-win
    - meson
    - ninja
    - winflexbison
    - strawberry-perl
' => 
  array (
    'postgresql' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'postgres/postgres',
          'match' => 'REL_18_\\d+',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => '@/postgresql.txt',
          ),
          'license' => 'PostgreSQL',
        ),
      ),
      'depends@unix' => 
      array (
        0 => 'libiconv',
        1 => 'libxml2',
        2 => 'openssl',
        3 => 'zlib',
        4 => 'libedit',
      ),
      'depends@windows' => 
      array (
        0 => 'openssl',
        1 => 'zlib',
      ),
      'suggests@unix' => 
      array (
        0 => 'icu',
        1 => 'libxslt',
        2 => 'ldap',
        3 => 'zstd',
      ),
      'pkg-configs' => 
      array (
        0 => 'libpq',
      ),
      'static-libs@windows' => 
      array (
        0 => 'libpq.lib',
        1 => 'libpgport.lib',
        2 => 'libpgcommon.lib',
      ),
      'tools@windows' => 
      array (
        0 => 'python-win',
        1 => 'meson',
        2 => 'ninja',
        3 => 'winflexbison',
        4 => 'strawberry-perl',
      ),
    ),
  ),
  'pthreads4w:
  type: library
  artifact:
    source:
      type: git
      rev: master
      url: \'https://git.code.sf.net/p/pthreads4w/code\'
    metadata:
      license-files: [LICENSE]
      license: Apache-2.0
  static-libs@windows:
    - libpthreadVC3.lib
    - pthreadVC3.lib
' => 
  array (
    'pthreads4w' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'rev' => 'master',
          'url' => 'https://git.code.sf.net/p/pthreads4w/code',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'Apache-2.0',
        ),
      ),
      'static-libs@windows' => 
      array (
        0 => 'libpthreadVC3.lib',
        1 => 'pthreadVC3.lib',
      ),
    ),
  ),
  'qdbm:
  type: library
  artifact:
    source:
      type: git
      url: \'https://github.com/static-php/qdbm.git\'
      rev: main
    metadata:
      license-files: [COPYING]
      license: \'GPL-2.0-only OR LGPL-2.1-only\'
  static-libs@unix:
    - libqdbm.a
  static-libs@windows:
    - qdbm_a.lib
' => 
  array (
    'qdbm' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'url' => 'https://github.com/static-php/qdbm.git',
          'rev' => 'main',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'GPL-2.0-only OR LGPL-2.1-only',
        ),
      ),
      'static-libs@unix' => 
      array (
        0 => 'libqdbm.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'qdbm_a.lib',
      ),
    ),
  ),
  'readline:
  type: library
  artifact:
    source:
      type: filelist
      url: \'https://ftp.gnu.org/gnu/readline/\'
      regex: \'/href="(?<file>readline-(?<version>[^"]+)\\.tar\\.gz)"/\'
    source-mirror:
      type: filelist
      url: \'https://ftpmirror.gnu.org/gnu/readline/\'
      regex: \'/href="(?<file>readline-(?<version>[^"]+)\\.tar\\.gz)"/\'
    metadata:
      license-files: [COPYING]
      license: GPL-3.0-or-later
  depends:
    - ncurses
  static-libs@unix:
    - libreadline.a
' => 
  array (
    'readline' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'filelist',
          'url' => 'https://ftp.gnu.org/gnu/readline/',
          'regex' => '/href="(?<file>readline-(?<version>[^"]+)\\.tar\\.gz)"/',
        ),
        'source-mirror' => 
        array (
          'type' => 'filelist',
          'url' => 'https://ftpmirror.gnu.org/gnu/readline/',
          'regex' => '/href="(?<file>readline-(?<version>[^"]+)\\.tar\\.gz)"/',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'GPL-3.0-or-later',
        ),
      ),
      'depends' => 
      array (
        0 => 'ncurses',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libreadline.a',
      ),
    ),
  ),
  'snappy:
  type: library
  artifact:
    source:
      type: git
      rev: main
      url: \'https://github.com/google/snappy\'
    metadata:
      license-files: [COPYING]
      license: BSD-3-Clause
  depends:
    - zlib
  headers@unix:
    - snappy.h
    - snappy-c.h
    - snappy-sinksource.h
    - snappy-stubs-public.h
  headers@windows:
    - snappy.h
    - snappy-c.h
    - snappy-sinksource.h
    - snappy-stubs-public.h
  lang: cpp
  static-libs@unix:
    - libsnappy.a
  static-libs@windows:
    - snappy.lib
' => 
  array (
    'snappy' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'rev' => 'main',
          'url' => 'https://github.com/google/snappy',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'BSD-3-Clause',
        ),
      ),
      'depends' => 
      array (
        0 => 'zlib',
      ),
      'headers@unix' => 
      array (
        0 => 'snappy.h',
        1 => 'snappy-c.h',
        2 => 'snappy-sinksource.h',
        3 => 'snappy-stubs-public.h',
      ),
      'headers@windows' => 
      array (
        0 => 'snappy.h',
        1 => 'snappy-c.h',
        2 => 'snappy-sinksource.h',
        3 => 'snappy-stubs-public.h',
      ),
      'lang' => 'cpp',
      'static-libs@unix' => 
      array (
        0 => 'libsnappy.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'snappy.lib',
      ),
    ),
  ),
  'sqlite:
  type: library
  artifact:
    source: \'https://www.sqlite.org/2024/sqlite-autoconf-3450200.tar.gz\'
    metadata:
      license-files: [\'@/sqlite.txt\']
      license: Unlicense
  headers:
    - sqlite3.h
    - sqlite3ext.h
  static-libs@unix:
    - libsqlite3.a
  static-libs@windows:
    - libsqlite3_a.lib
' => 
  array (
    'sqlite' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 'https://www.sqlite.org/2024/sqlite-autoconf-3450200.tar.gz',
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => '@/sqlite.txt',
          ),
          'license' => 'Unlicense',
        ),
      ),
      'headers' => 
      array (
        0 => 'sqlite3.h',
        1 => 'sqlite3ext.h',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libsqlite3.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'libsqlite3_a.lib',
      ),
    ),
  ),
  'tidy:
  type: library
  artifact:
    source:
      type: ghtar
      repo: htacg/tidy-html5
      prefer-stable: true
    metadata:
      license-files: [README/LICENSE.md]
      license: W3C
  static-libs@unix:
    - libtidy.a
  static-libs@windows:
    - tidy_a.lib
' => 
  array (
    'tidy' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'htacg/tidy-html5',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'README/LICENSE.md',
          ),
          'license' => 'W3C',
        ),
      ),
      'static-libs@unix' => 
      array (
        0 => 'libtidy.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'tidy_a.lib',
      ),
    ),
  ),
  'unixodbc:
  type: library
  artifact:
    source: \'https://www.unixodbc.org/unixODBC-2.3.12.tar.gz\'
    metadata:
      license-files: [COPYING]
      license: LGPL-2.1-only
  depends:
    - libiconv
  static-libs@unix:
    - libodbc.a
    - libodbccr.a
    - libodbcinst.a
' => 
  array (
    'unixodbc' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 'https://www.unixodbc.org/unixODBC-2.3.12.tar.gz',
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'LGPL-2.1-only',
        ),
      ),
      'depends' => 
      array (
        0 => 'libiconv',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libodbc.a',
        1 => 'libodbccr.a',
        2 => 'libodbcinst.a',
      ),
    ),
  ),
  'watcher:
  type: library
  artifact:
    source:
      type: ghtar
      repo: e-dant/watcher
      prefer-stable: true
    metadata:
      license-files: [license]
      license: MIT
  frameworks:
    - CoreServices
  headers:
    - wtr/watcher-c.h
  lang: cpp
  static-libs@unix:
    - libwatcher-c.a
' => 
  array (
    'watcher' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'e-dant/watcher',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'license',
          ),
          'license' => 'MIT',
        ),
      ),
      'frameworks' => 
      array (
        0 => 'CoreServices',
      ),
      'headers' => 
      array (
        0 => 'wtr/watcher-c.h',
      ),
      'lang' => 'cpp',
      'static-libs@unix' => 
      array (
        0 => 'libwatcher-c.a',
      ),
    ),
  ),
  'wineditline:
  type: library
  artifact:
    source:
      type: git
      url: \'https://github.com/winlibs/wineditline.git\'
      rev: master
    metadata:
      license-files: [COPYING]
      license: GPL-2.0-or-later
  headers:
    - editline
  static-libs@windows:
    - edit_a.lib
' => 
  array (
    'wineditline' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'url' => 'https://github.com/winlibs/wineditline.git',
          'rev' => 'master',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'GPL-2.0-or-later',
        ),
      ),
      'headers' => 
      array (
        0 => 'editline',
      ),
      'static-libs@windows' => 
      array (
        0 => 'edit_a.lib',
      ),
    ),
  ),
  'xz:
  type: library
  artifact:
    source:
      type: ghrel
      repo: tukaani-project/xz
      match: xz.+\\.tar\\.xz
      prefer-stable: true
    metadata:
      license-files: [COPYING]
      license: 0BSD
  depends@unix:
    - libiconv
  headers@unix:
    - lzma
  headers@windows:
    - lzma
    - lzma.h
  pkg-configs:
    - liblzma
  static-libs@unix:
    - liblzma.a
  static-libs@windows:
    - lzma.lib
    - liblzma_a.lib
' => 
  array (
    'xz' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'tukaani-project/xz',
          'match' => 'xz.+\\.tar\\.xz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => '0BSD',
        ),
      ),
      'depends@unix' => 
      array (
        0 => 'libiconv',
      ),
      'headers@unix' => 
      array (
        0 => 'lzma',
      ),
      'headers@windows' => 
      array (
        0 => 'lzma',
        1 => 'lzma.h',
      ),
      'pkg-configs' => 
      array (
        0 => 'liblzma',
      ),
      'static-libs@unix' => 
      array (
        0 => 'liblzma.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'lzma.lib',
        1 => 'liblzma_a.lib',
      ),
    ),
  ),
  'zlib:
  type: library
  artifact:
    source:
      type: ghrel
      repo: madler/zlib
      match: zlib.+\\.tar\\.gz
    metadata:
      license-files: [\'@/zlib.txt\']
      license: Zlib-Custom
  headers:
    - zlib.h
    - zconf.h
  static-libs@unix:
    - libz.a
  static-libs@windows:
    - zlibstatic.lib
    - zlib_a.lib
' => 
  array (
    'zlib' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'madler/zlib',
          'match' => 'zlib.+\\.tar\\.gz',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => '@/zlib.txt',
          ),
          'license' => 'Zlib-Custom',
        ),
      ),
      'headers' => 
      array (
        0 => 'zlib.h',
        1 => 'zconf.h',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libz.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'zlibstatic.lib',
        1 => 'zlib_a.lib',
      ),
    ),
  ),
  'zstd:
  type: library
  artifact:
    source:
      type: ghrel
      repo: facebook/zstd
      match: zstd.+\\.tar\\.gz
      prefer-stable: true
    metadata:
      license-files: [LICENSE]
      license: BSD-3-Clause
  headers@unix:
    - zdict.h
    - zstd.h
    - zstd_errors.h
  pkg-configs:
    - libzstd
  static-libs@unix:
    - libzstd.a
  static-libs@windows:
    - zstd.lib
    - libzstd.lib
' => 
  array (
    'zstd' => 
    array (
      'type' => 'library',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'facebook/zstd',
          'match' => 'zstd.+\\.tar\\.gz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-3-Clause',
        ),
      ),
      'headers@unix' => 
      array (
        0 => 'zdict.h',
        1 => 'zstd.h',
        2 => 'zstd_errors.h',
      ),
      'pkg-configs' => 
      array (
        0 => 'libzstd',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libzstd.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'zstd.lib',
        1 => 'libzstd.lib',
      ),
    ),
  ),
  'curl:
  type: target
  artifact:
    source:
      type: ghrel
      repo: curl/curl
      match: curl.+\\.tar\\.xz
      prefer-stable: true
    metadata:
      license-files: [COPYING]
      license: curl
  depends@unix:
    - openssl
    - zlib
  depends@windows:
    - zlib
    - openssl
    - libssh2
    - nghttp2
    - brotli
    - zstd
  suggests@unix:
    - libssh2
    - brotli
    - nghttp2
    - nghttp3
    - ngtcp2
    - zstd
    - libcares
    - ldap
    - idn2
    - krb5
  frameworks:
    - CoreFoundation
    - CoreServices
    - SystemConfiguration
  headers:
    - curl
  static-bins@unix:
    - curl
  static-libs@unix:
    - libcurl.a
  static-libs@windows:
    - libcurl_a.lib
' => 
  array (
    'curl' => 
    array (
      'type' => 'target',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'curl/curl',
          'match' => 'curl.+\\.tar\\.xz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'curl',
        ),
      ),
      'depends@unix' => 
      array (
        0 => 'openssl',
        1 => 'zlib',
      ),
      'depends@windows' => 
      array (
        0 => 'zlib',
        1 => 'openssl',
        2 => 'libssh2',
        3 => 'nghttp2',
        4 => 'brotli',
        5 => 'zstd',
      ),
      'suggests@unix' => 
      array (
        0 => 'libssh2',
        1 => 'brotli',
        2 => 'nghttp2',
        3 => 'nghttp3',
        4 => 'ngtcp2',
        5 => 'zstd',
        6 => 'libcares',
        7 => 'ldap',
        8 => 'idn2',
        9 => 'krb5',
      ),
      'frameworks' => 
      array (
        0 => 'CoreFoundation',
        1 => 'CoreServices',
        2 => 'SystemConfiguration',
      ),
      'headers' => 
      array (
        0 => 'curl',
      ),
      'static-bins@unix' => 
      array (
        0 => 'curl',
      ),
      'static-libs@unix' => 
      array (
        0 => 'libcurl.a',
      ),
      'static-libs@windows' => 
      array (
        0 => 'libcurl_a.lib',
      ),
    ),
  ),
  'frankenphp:
  type: target
  artifact:
    source:
      type: ghtar
      repo: php/frankenphp
      prefer-stable: true
    metadata:
      license-files: [LICENSE]
      license: MIT
  depends:
    - php-embed
  depends@windows:
    - php-embed
    - pthreads4w
  suggests@unix:
    - brotli
    - watcher
  suggests@windows:
    - brotli
  static-bins@unix:
    - frankenphp
  static-bins@windows:
    - frankenphp.exe
  tools:
    - go-xcaddy
  tools@windows:
    - go-win
' => 
  array (
    'frankenphp' => 
    array (
      'type' => 'target',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'php/frankenphp',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'MIT',
        ),
      ),
      'depends' => 
      array (
        0 => 'php-embed',
      ),
      'depends@windows' => 
      array (
        0 => 'php-embed',
        1 => 'pthreads4w',
      ),
      'suggests@unix' => 
      array (
        0 => 'brotli',
        1 => 'watcher',
      ),
      'suggests@windows' => 
      array (
        0 => 'brotli',
      ),
      'static-bins@unix' => 
      array (
        0 => 'frankenphp',
      ),
      'static-bins@windows' => 
      array (
        0 => 'frankenphp.exe',
      ),
      'tools' => 
      array (
        0 => 'go-xcaddy',
      ),
      'tools@windows' => 
      array (
        0 => 'go-win',
      ),
    ),
  ),
  'htop:
  type: target
  artifact:
    source:
      type: ghrel
      repo: htop-dev/htop
      match: htop.+\\.tar\\.xz
      prefer-stable: true
  depends:
    - ncursesw
' => 
  array (
    'htop' => 
    array (
      'type' => 'target',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'htop-dev/htop',
          'match' => 'htop.+\\.tar\\.xz',
          'prefer-stable' => true,
        ),
      ),
      'depends' => 
      array (
        0 => 'ncursesw',
      ),
    ),
  ),
  'llvm-compiler-rt:
  type: target
  artifact:
    source:
      type: custom
      source-root: compiler-rt
    metadata:
      license-files: [LICENSE.TXT]
      license: Apache-2.0-with-LLVM-exception
  tools:
    - zig
' => 
  array (
    'llvm-compiler-rt' => 
    array (
      'type' => 'target',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'custom',
          'source-root' => 'compiler-rt',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE.TXT',
          ),
          'license' => 'Apache-2.0-with-LLVM-exception',
        ),
      ),
      'tools' => 
      array (
        0 => 'zig',
      ),
    ),
  ),
  'msys2-build-essentials:
  type: target
  artifact:
    binary: custom
  env:
    SPC_MSYS2_PATH: \'{pkg_root_path}/msys2-build-essentials/msys64\'
  path@windows:
    - \'{pkg_root_path}/msys2-build-essentials/msys64/usr/bin\'
' => 
  array (
    'msys2-build-essentials' => 
    array (
      'type' => 'target',
      'artifact' => 
      array (
        'binary' => 'custom',
      ),
      'env' => 
      array (
        'SPC_MSYS2_PATH' => '{pkg_root_path}/msys2-build-essentials/msys64',
      ),
      'path@windows' => 
      array (
        0 => '{pkg_root_path}/msys2-build-essentials/msys64/usr/bin',
      ),
    ),
  ),
  'musl-toolchain:
  type: target
  artifact:
    binary:
      linux-x86_64: { type: url, url: \'https://dl.static-php.dev/static-php-cli/deps/musl-toolchain/x86_64-musl-toolchain.tgz\', extract: \'{pkg_root_path}/musl-toolchain\' }
      linux-aarch64: { type: url, url: \'https://dl.static-php.dev/static-php-cli/deps/musl-toolchain/aarch64-musl-toolchain.tgz\', extract: \'{pkg_root_path}/musl-toolchain\' }
' => 
  array (
    'musl-toolchain' => 
    array (
      'type' => 'target',
      'artifact' => 
      array (
        'binary' => 
        array (
          'linux-x86_64' => 
          array (
            'type' => 'url',
            'url' => 'https://dl.static-php.dev/static-php-cli/deps/musl-toolchain/x86_64-musl-toolchain.tgz',
            'extract' => '{pkg_root_path}/musl-toolchain',
          ),
          'linux-aarch64' => 
          array (
            'type' => 'url',
            'url' => 'https://dl.static-php.dev/static-php-cli/deps/musl-toolchain/aarch64-musl-toolchain.tgz',
            'extract' => '{pkg_root_path}/musl-toolchain',
          ),
        ),
      ),
    ),
  ),
  'php:
  type: target
  artifact: php-src
  depends@macos:
    - libxml2
php-cgi:
  type: virtual-target
  depends:
    - php
php-cli:
  type: virtual-target
  depends:
    - php
php-embed:
  type: virtual-target
  depends:
    - php
php-fpm:
  type: virtual-target
  depends:
    - php
  suggests@linux:
    - libacl
php-micro:
  type: virtual-target
  artifact:
    source:
      type: git
      extract: php-src/sapi/micro
      rev: master
      url: \'https://github.com/static-php/phpmicro\'
  depends:
    - php
' => 
  array (
    'php' => 
    array (
      'type' => 'target',
      'artifact' => 'php-src',
      'depends@macos' => 
      array (
        0 => 'libxml2',
      ),
    ),
    'php-cgi' => 
    array (
      'type' => 'virtual-target',
      'depends' => 
      array (
        0 => 'php',
      ),
    ),
    'php-cli' => 
    array (
      'type' => 'virtual-target',
      'depends' => 
      array (
        0 => 'php',
      ),
    ),
    'php-embed' => 
    array (
      'type' => 'virtual-target',
      'depends' => 
      array (
        0 => 'php',
      ),
    ),
    'php-fpm' => 
    array (
      'type' => 'virtual-target',
      'depends' => 
      array (
        0 => 'php',
      ),
      'suggests@linux' => 
      array (
        0 => 'libacl',
      ),
    ),
    'php-micro' => 
    array (
      'type' => 'virtual-target',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'extract' => 'php-src/sapi/micro',
          'rev' => 'master',
          'url' => 'https://github.com/static-php/phpmicro',
        ),
      ),
      'depends' => 
      array (
        0 => 'php',
      ),
    ),
  ),
  're2c:
  type: target
  artifact:
    source:
      type: ghrel
      repo: skvadrik/re2c
      match: re2c.+\\.tar\\.xz
      prefer-stable: true
    source-mirror: \'https://dl.static-php.dev/static-php-cli/deps/re2c/re2c-4.3.tar.xz\'
    metadata:
      license-files: [LICENSE]
      license: \'MIT OR Apache-2.0\'
  static-bins@unix:
    - re2c
' => 
  array (
    're2c' => 
    array (
      'type' => 'target',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'skvadrik/re2c',
          'match' => 're2c.+\\.tar\\.xz',
          'prefer-stable' => true,
        ),
        'source-mirror' => 'https://dl.static-php.dev/static-php-cli/deps/re2c/re2c-4.3.tar.xz',
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'MIT OR Apache-2.0',
        ),
      ),
      'static-bins@unix' => 
      array (
        0 => 're2c',
      ),
    ),
  ),
  'rust:
  type: target
  artifact:
    binary: custom
  path:
    - \'{pkg_root_path}/rust/bin\'
' => 
  array (
    'rust' => 
    array (
      'type' => 'target',
      'artifact' => 
      array (
        'binary' => 'custom',
      ),
      'path' => 
      array (
        0 => '{pkg_root_path}/rust/bin',
      ),
    ),
  ),
  'ext-bcmath:
  type: php-extension
ext-bz2:
  type: php-extension
  depends:
    - bzip2
  php-extension:
    arg-type@unix: with-path
    arg-type@windows: with
ext-calendar:
  type: php-extension
ext-com_dotnet:
  type: php-extension
  php-extension:
    os:
      - Windows
    arg-type@windows: \'--enable-com-dotnet=yes\'
ext-ctype:
  type: php-extension
ext-curl:
  type: php-extension
  depends:
    - curl
  depends@windows:
    - curl
    - ext-zlib
    - ext-openssl
  php-extension:
    arg-type: with
ext-dba:
  type: php-extension
  suggests:
    - qdbm
  php-extension:
    arg-type: custom
ext-dom:
  type: php-extension
  depends:
    - ext-xml
  php-extension:
    arg-type: enable
    arg-type@windows: with
ext-exif:
  type: php-extension
  depends@windows:
    - ext-mbstring
ext-ffi:
  type: php-extension
  depends@unix:
    - libffi
  depends@windows:
    - libffi-win
  php-extension:
    arg-type: with
ext-fileinfo:
  type: php-extension
ext-filter:
  type: php-extension
ext-ftp:
  type: php-extension
  suggests:
    - ext-openssl
ext-gd:
  type: php-extension
  depends:
    - zlib
    - libpng
    - ext-zlib
  suggests:
    - libavif
    - libwebp
    - libjpeg
    - freetype
  php-extension:
    arg-type: custom
    arg-type@windows: with
ext-gettext:
  type: php-extension
  depends@unix:
    - gettext
  depends@windows:
    - gettext-win
  php-extension:
    arg-type: with-path
    arg-type@windows: with
ext-gmp:
  type: php-extension
  depends@unix:
    - gmp
  depends@windows:
    - mpir
  php-extension:
    arg-type: with-path
    arg-type@windows: with
ext-iconv:
  type: php-extension
  depends@unix:
    - libiconv
  depends@windows:
    - libiconv-win
  php-extension:
    arg-type@unix: with-path
    arg-type@windows: with
ext-intl:
  type: php-extension
  depends:
    - icu
ext-ldap:
  type: php-extension
  depends:
    - ldap
  suggests:
    - gmp
    - libsodium
    - ext-openssl
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: with-path
    arg-type@windows: with
ext-libxml:
  type: php-extension
  depends:
    - libxml2
  php-extension:
    build-with-php: true
    build-shared: false
    arg-type@unix: with-path
    arg-type@windows: with
ext-mbregex:
  type: php-extension
  depends:
    - onig
    - ext-mbstring
  php-extension:
    arg-type: custom
    build-shared: false
    build-static: true
    display-name: mbstring
ext-mbstring:
  type: php-extension
  php-extension:
    arg-type: custom
ext-mysqli:
  type: php-extension
  depends:
    - ext-mysqlnd
  php-extension:
    arg-type: with
    build-with-php: true
ext-mysqlnd:
  type: php-extension
  depends:
    - zlib
  php-extension:
    arg-type@unix: enable
    arg-type@windows: with
    build-with-php: true
ext-odbc:
  type: php-extension
  depends@unix:
    - unixodbc
  php-extension:
    arg-type@unix: \'--with-unixODBC@shared_path_suffix@\'
    arg-type@windows: enable
ext-opcache:
  type: php-extension
  php-extension:
    arg-type@unix: custom
    arg-type@windows: enable
    zend-extension: true
    display-name: \'Zend Opcache\'
ext-openssl:
  type: php-extension
  depends:
    - openssl
    - zlib
    - ext-zlib
  php-extension:
    arg-type: custom
    arg-type@windows: with
    build-with-php: true
ext-password-argon2:
  type: php-extension
  depends:
    - libargon2
  suggests:
    - ext-openssl
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: custom
    display-name: \'\'
ext-pcntl:
  type: php-extension
  php-extension:
    os:
      - Linux
      - Darwin
ext-pdo:
  type: php-extension
ext-pdo_mysql:
  type: php-extension
  depends:
    - ext-pdo
    - ext-mysqlnd
  php-extension:
    arg-type: with
ext-pdo_odbc:
  type: php-extension
  depends:
    - ext-pdo
  depends@unix:
    - unixodbc
    - ext-pdo
    - ext-odbc
  php-extension:
    arg-type: custom
ext-pdo_pgsql:
  type: php-extension
  depends:
    - ext-pdo
    - ext-pgsql
    - postgresql
  php-extension:
    arg-type@unix: custom
    arg-type@windows: \'--with-pdo-pgsql=yes\'
ext-pdo_sqlite:
  type: php-extension
  depends:
    - ext-pdo
    - ext-sqlite3
    - sqlite
  php-extension:
    arg-type: with
ext-pgsql:
  type: php-extension
  depends:
    - postgresql
  php-extension:
    arg-type: custom
ext-phar:
  type: php-extension
  depends:
    - zlib
ext-posix:
  type: php-extension
  php-extension:
    os:
      - Linux
      - Darwin
ext-readline:
  type: php-extension
  depends@unix:
    - libedit
  depends@windows:
    - wineditline
  php-extension:
    arg-type: \'--with-libedit --without-readline\'
    arg-type@windows: with
    build-shared: false
    build-static: true
ext-session:
  type: php-extension
ext-shmop:
  type: php-extension
  php-extension:
    build-with-php: true
ext-simplexml:
  type: php-extension
  depends:
    - ext-xml
  php-extension:
    arg-type@unix: enable
    arg-type@windows: with
    build-with-php: true
ext-snmp:
  type: php-extension
  depends:
    - net-snmp
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: with
ext-soap:
  type: php-extension
  depends:
    - ext-xml
    - ext-session
  php-extension:
    arg-type: enable
    build-with-php: true
ext-sockets:
  type: php-extension
ext-sodium:
  type: php-extension
  depends:
    - libsodium
  php-extension:
    arg-type: with
ext-sqlite3:
  type: php-extension
  depends:
    - sqlite
  php-extension:
    arg-type@unix: with-path
    arg-type@windows: with
    build-with-php: true
ext-sysvmsg:
  type: php-extension
  php-extension:
    os:
      - Linux
      - Darwin
ext-sysvsem:
  type: php-extension
  php-extension:
    os:
      - Linux
      - Darwin
ext-sysvshm:
  type: php-extension
ext-tidy:
  type: php-extension
  depends:
    - tidy
  php-extension:
    arg-type: with-path
ext-tokenizer:
  type: php-extension
  php-extension:
    build-with-php: true
ext-xml:
  type: php-extension
  depends:
    - ext-libxml
  depends@windows:
    - ext-iconv
    - ext-libxml
  php-extension:
    arg-type@unix: enable
    arg-type@windows: with
    build-with-php: true
ext-xmlreader:
  type: php-extension
  depends:
    - ext-xml
    - ext-dom
  php-extension:
    arg-type: enable
    build-with-php: true
ext-xmlwriter:
  type: php-extension
  depends:
    - ext-xml
  php-extension:
    arg-type: enable
    build-with-php: true
ext-xsl:
  type: php-extension
  depends:
    - libxslt
    - ext-xml
    - ext-dom
  php-extension:
    arg-type: with-path
    build-with-php: true
ext-zlib:
  type: php-extension
  depends:
    - zlib
  php-extension:
    arg-type: custom
    arg-type@windows: enable
    build-with-php: true
    build-shared: false
' => 
  array (
    'ext-bcmath' => 
    array (
      'type' => 'php-extension',
    ),
    'ext-bz2' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'bzip2',
      ),
      'php-extension' => 
      array (
        'arg-type@unix' => 'with-path',
        'arg-type@windows' => 'with',
      ),
    ),
    'ext-calendar' => 
    array (
      'type' => 'php-extension',
    ),
    'ext-com_dotnet' => 
    array (
      'type' => 'php-extension',
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Windows',
        ),
        'arg-type@windows' => '--enable-com-dotnet=yes',
      ),
    ),
    'ext-ctype' => 
    array (
      'type' => 'php-extension',
    ),
    'ext-curl' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'curl',
      ),
      'depends@windows' => 
      array (
        0 => 'curl',
        1 => 'ext-zlib',
        2 => 'ext-openssl',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'with',
      ),
    ),
    'ext-dba' => 
    array (
      'type' => 'php-extension',
      'suggests' => 
      array (
        0 => 'qdbm',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'custom',
      ),
    ),
    'ext-dom' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'ext-xml',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'enable',
        'arg-type@windows' => 'with',
      ),
    ),
    'ext-exif' => 
    array (
      'type' => 'php-extension',
      'depends@windows' => 
      array (
        0 => 'ext-mbstring',
      ),
    ),
    'ext-ffi' => 
    array (
      'type' => 'php-extension',
      'depends@unix' => 
      array (
        0 => 'libffi',
      ),
      'depends@windows' => 
      array (
        0 => 'libffi-win',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'with',
      ),
    ),
    'ext-fileinfo' => 
    array (
      'type' => 'php-extension',
    ),
    'ext-filter' => 
    array (
      'type' => 'php-extension',
    ),
    'ext-ftp' => 
    array (
      'type' => 'php-extension',
      'suggests' => 
      array (
        0 => 'ext-openssl',
      ),
    ),
    'ext-gd' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'zlib',
        1 => 'libpng',
        2 => 'ext-zlib',
      ),
      'suggests' => 
      array (
        0 => 'libavif',
        1 => 'libwebp',
        2 => 'libjpeg',
        3 => 'freetype',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'custom',
        'arg-type@windows' => 'with',
      ),
    ),
    'ext-gettext' => 
    array (
      'type' => 'php-extension',
      'depends@unix' => 
      array (
        0 => 'gettext',
      ),
      'depends@windows' => 
      array (
        0 => 'gettext-win',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'with-path',
        'arg-type@windows' => 'with',
      ),
    ),
    'ext-gmp' => 
    array (
      'type' => 'php-extension',
      'depends@unix' => 
      array (
        0 => 'gmp',
      ),
      'depends@windows' => 
      array (
        0 => 'mpir',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'with-path',
        'arg-type@windows' => 'with',
      ),
    ),
    'ext-iconv' => 
    array (
      'type' => 'php-extension',
      'depends@unix' => 
      array (
        0 => 'libiconv',
      ),
      'depends@windows' => 
      array (
        0 => 'libiconv-win',
      ),
      'php-extension' => 
      array (
        'arg-type@unix' => 'with-path',
        'arg-type@windows' => 'with',
      ),
    ),
    'ext-intl' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'icu',
      ),
    ),
    'ext-ldap' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'ldap',
      ),
      'suggests' => 
      array (
        0 => 'gmp',
        1 => 'libsodium',
        2 => 'ext-openssl',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => 'with-path',
        'arg-type@windows' => 'with',
      ),
    ),
    'ext-libxml' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'libxml2',
      ),
      'php-extension' => 
      array (
        'build-with-php' => true,
        'build-shared' => false,
        'arg-type@unix' => 'with-path',
        'arg-type@windows' => 'with',
      ),
    ),
    'ext-mbregex' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'onig',
        1 => 'ext-mbstring',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'custom',
        'build-shared' => false,
        'build-static' => true,
        'display-name' => 'mbstring',
      ),
    ),
    'ext-mbstring' => 
    array (
      'type' => 'php-extension',
      'php-extension' => 
      array (
        'arg-type' => 'custom',
      ),
    ),
    'ext-mysqli' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'ext-mysqlnd',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'with',
        'build-with-php' => true,
      ),
    ),
    'ext-mysqlnd' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'zlib',
      ),
      'php-extension' => 
      array (
        'arg-type@unix' => 'enable',
        'arg-type@windows' => 'with',
        'build-with-php' => true,
      ),
    ),
    'ext-odbc' => 
    array (
      'type' => 'php-extension',
      'depends@unix' => 
      array (
        0 => 'unixodbc',
      ),
      'php-extension' => 
      array (
        'arg-type@unix' => '--with-unixODBC@shared_path_suffix@',
        'arg-type@windows' => 'enable',
      ),
    ),
    'ext-opcache' => 
    array (
      'type' => 'php-extension',
      'php-extension' => 
      array (
        'arg-type@unix' => 'custom',
        'arg-type@windows' => 'enable',
        'zend-extension' => true,
        'display-name' => 'Zend Opcache',
      ),
    ),
    'ext-openssl' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'openssl',
        1 => 'zlib',
        2 => 'ext-zlib',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'custom',
        'arg-type@windows' => 'with',
        'build-with-php' => true,
      ),
    ),
    'ext-password-argon2' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'libargon2',
      ),
      'suggests' => 
      array (
        0 => 'ext-openssl',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => 'custom',
        'display-name' => '',
      ),
    ),
    'ext-pcntl' => 
    array (
      'type' => 'php-extension',
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
      ),
    ),
    'ext-pdo' => 
    array (
      'type' => 'php-extension',
    ),
    'ext-pdo_mysql' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'ext-pdo',
        1 => 'ext-mysqlnd',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'with',
      ),
    ),
    'ext-pdo_odbc' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'ext-pdo',
      ),
      'depends@unix' => 
      array (
        0 => 'unixodbc',
        1 => 'ext-pdo',
        2 => 'ext-odbc',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'custom',
      ),
    ),
    'ext-pdo_pgsql' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'ext-pdo',
        1 => 'ext-pgsql',
        2 => 'postgresql',
      ),
      'php-extension' => 
      array (
        'arg-type@unix' => 'custom',
        'arg-type@windows' => '--with-pdo-pgsql=yes',
      ),
    ),
    'ext-pdo_sqlite' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'ext-pdo',
        1 => 'ext-sqlite3',
        2 => 'sqlite',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'with',
      ),
    ),
    'ext-pgsql' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'postgresql',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'custom',
      ),
    ),
    'ext-phar' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'zlib',
      ),
    ),
    'ext-posix' => 
    array (
      'type' => 'php-extension',
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
      ),
    ),
    'ext-readline' => 
    array (
      'type' => 'php-extension',
      'depends@unix' => 
      array (
        0 => 'libedit',
      ),
      'depends@windows' => 
      array (
        0 => 'wineditline',
      ),
      'php-extension' => 
      array (
        'arg-type' => '--with-libedit --without-readline',
        'arg-type@windows' => 'with',
        'build-shared' => false,
        'build-static' => true,
      ),
    ),
    'ext-session' => 
    array (
      'type' => 'php-extension',
    ),
    'ext-shmop' => 
    array (
      'type' => 'php-extension',
      'php-extension' => 
      array (
        'build-with-php' => true,
      ),
    ),
    'ext-simplexml' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'ext-xml',
      ),
      'php-extension' => 
      array (
        'arg-type@unix' => 'enable',
        'arg-type@windows' => 'with',
        'build-with-php' => true,
      ),
    ),
    'ext-snmp' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'net-snmp',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => 'with',
      ),
    ),
    'ext-soap' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'ext-xml',
        1 => 'ext-session',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'enable',
        'build-with-php' => true,
      ),
    ),
    'ext-sockets' => 
    array (
      'type' => 'php-extension',
    ),
    'ext-sodium' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'libsodium',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'with',
      ),
    ),
    'ext-sqlite3' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'sqlite',
      ),
      'php-extension' => 
      array (
        'arg-type@unix' => 'with-path',
        'arg-type@windows' => 'with',
        'build-with-php' => true,
      ),
    ),
    'ext-sysvmsg' => 
    array (
      'type' => 'php-extension',
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
      ),
    ),
    'ext-sysvsem' => 
    array (
      'type' => 'php-extension',
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
      ),
    ),
    'ext-sysvshm' => 
    array (
      'type' => 'php-extension',
    ),
    'ext-tidy' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'tidy',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'with-path',
      ),
    ),
    'ext-tokenizer' => 
    array (
      'type' => 'php-extension',
      'php-extension' => 
      array (
        'build-with-php' => true,
      ),
    ),
    'ext-xml' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'ext-libxml',
      ),
      'depends@windows' => 
      array (
        0 => 'ext-iconv',
        1 => 'ext-libxml',
      ),
      'php-extension' => 
      array (
        'arg-type@unix' => 'enable',
        'arg-type@windows' => 'with',
        'build-with-php' => true,
      ),
    ),
    'ext-xmlreader' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'ext-xml',
        1 => 'ext-dom',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'enable',
        'build-with-php' => true,
      ),
    ),
    'ext-xmlwriter' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'ext-xml',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'enable',
        'build-with-php' => true,
      ),
    ),
    'ext-xsl' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'libxslt',
        1 => 'ext-xml',
        2 => 'ext-dom',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'with-path',
        'build-with-php' => true,
      ),
    ),
    'ext-zlib' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'zlib',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'custom',
        'arg-type@windows' => 'enable',
        'build-with-php' => true,
        'build-shared' => false,
      ),
    ),
  ),
  'ext-amqp:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: php-amqp/php-amqp
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  depends:
    - librabbitmq
  depends@windows:
    - librabbitmq
    - ext-openssl
  php-extension:
    arg-type: \'--with-amqp@shared_suffix@ --with-librabbitmq-dir=@build_root_path@\'
    arg-type@windows: \'--with-amqp\'
' => 
  array (
    'ext-amqp' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'php-amqp/php-amqp',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'depends' => 
      array (
        0 => 'librabbitmq',
      ),
      'depends@windows' => 
      array (
        0 => 'librabbitmq',
        1 => 'ext-openssl',
      ),
      'php-extension' => 
      array (
        'arg-type' => '--with-amqp@shared_suffix@ --with-librabbitmq-dir=@build_root_path@',
        'arg-type@windows' => '--with-amqp',
      ),
    ),
  ),
  'ext-apcu:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: apcu/apcu
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
' => 
  array (
    'ext-apcu' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'apcu/apcu',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
    ),
  ),
  'ext-ast:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: nikic/php-ast
    metadata:
      license-files: [LICENSE]
      license: BSD-3-Clause
' => 
  array (
    'ext-ast' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'nikic/php-ast',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-3-Clause',
        ),
      ),
    ),
  ),
  'ext-brotli:
  type: php-extension
  artifact:
    source:
      type: ghtagtar
      repo: kjdev/php-ext-brotli
    metadata:
      license-files: [LICENSE]
      license: MIT
  depends:
    - brotli
  php-extension:
    arg-type: \'--enable-brotli@shared_suffix@ --with-libbrotli\'
' => 
  array (
    'ext-brotli' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'kjdev/php-ext-brotli',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'MIT',
        ),
      ),
      'depends' => 
      array (
        0 => 'brotli',
      ),
      'php-extension' => 
      array (
        'arg-type' => '--enable-brotli@shared_suffix@ --with-libbrotli',
      ),
    ),
  ),
  'ext-clickhouse:
  type: php-extension
  artifact:
    source:
      type: ghtar
      repo: iliaal/php_clickhouse
      prefer-stable: true
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  suggests@unix:
    - openssl
  lang: cpp
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type@unix: custom
' => 
  array (
    'ext-clickhouse' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'iliaal/php_clickhouse',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'suggests@unix' => 
      array (
        0 => 'openssl',
      ),
      'lang' => 'cpp',
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type@unix' => 'custom',
      ),
    ),
  ),
  'ext-decimal:
  type: php-extension
  artifact:
    source:
      type: ghtagtar
      repo: php-decimal/ext-decimal
      match: \'v2\\.\\d.*\'
    metadata:
      license-files: [LICENSE]
      license: MIT
  depends:
    - libmpdec
  php-extension:
    arg-type@unix: \'--enable-decimal --with-libmpdec-path=@build_root_path@\'
    arg-type@windows: \'--with-decimal\'
' => 
  array (
    'ext-decimal' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'php-decimal/ext-decimal',
          'match' => 'v2\\.\\d.*',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'MIT',
        ),
      ),
      'depends' => 
      array (
        0 => 'libmpdec',
      ),
      'php-extension' => 
      array (
        'arg-type@unix' => '--enable-decimal --with-libmpdec-path=@build_root_path@',
        'arg-type@windows' => '--with-decimal',
      ),
    ),
  ),
  'ext-deepclone:
  type: php-extension
  artifact:
    source:
      type: ghtagtar
      repo: symfony/php-ext-deepclone
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
' => 
  array (
    'ext-deepclone' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'symfony/php-ext-deepclone',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
    ),
  ),
  'ext-dio:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: pecl/dio
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
' => 
  array (
    'ext-dio' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'pecl/dio',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
    ),
  ),
  'ext-ds:
  type: php-extension
  artifact:
    source:
      type: git
      url: \'https://github.com/php-ds/ext-ds.git\'
      rev: master
    metadata:
      license-files: [LICENSE]
      license: MIT
' => 
  array (
    'ext-ds' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'url' => 'https://github.com/php-ds/ext-ds.git',
          'rev' => 'master',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'MIT',
        ),
      ),
    ),
  ),
  'ext-ev:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: osmanov/pecl-ev
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  depends:
    - ext-sockets
  php-extension:
    arg-type@windows: with
' => 
  array (
    'ext-ev' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'osmanov/pecl-ev',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'depends' => 
      array (
        0 => 'ext-sockets',
      ),
      'php-extension' => 
      array (
        'arg-type@windows' => 'with',
      ),
    ),
  ),
  'ext-event:
  type: php-extension
  artifact:
    source:
      type: url
      url: \'https://bitbucket.org/osmanov/pecl-event/get/3.1.4.tar.gz\'
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  depends:
    - libevent
    - ext-openssl
  suggests:
    - ext-sockets
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: custom
' => 
  array (
    'ext-event' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'url',
          'url' => 'https://bitbucket.org/osmanov/pecl-event/get/3.1.4.tar.gz',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'depends' => 
      array (
        0 => 'libevent',
        1 => 'ext-openssl',
      ),
      'suggests' => 
      array (
        0 => 'ext-sockets',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => 'custom',
      ),
    ),
  ),
  'ext-excimer:
  type: php-extension
  artifact:
    source:
      type: ghtagtar
      repo: wikimedia/mediawiki-php-excimer
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  php-extension:
    os:
      - Linux
      - Darwin
' => 
  array (
    'ext-excimer' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'wikimedia/mediawiki-php-excimer',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
      ),
    ),
  ),
  'ext-fastchart:
  type: php-extension
  artifact:
    source:
      type: ghtar
      repo: iliaal/fastchart
      prefer-stable: true
    metadata:
      license-files: [LICENSE]
  depends:
    - freetype
  suggests:
    - libpng
    - libjpeg
    - libwebp
  php-extension:
    os:
      - Linux
      - Darwin
' => 
  array (
    'ext-fastchart' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'iliaal/fastchart',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
        ),
      ),
      'depends' => 
      array (
        0 => 'freetype',
      ),
      'suggests' => 
      array (
        0 => 'libpng',
        1 => 'libjpeg',
        2 => 'libwebp',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
      ),
    ),
  ),
  'ext-fastjson:
  type: php-extension
  artifact:
    source:
      type: ghtar
      repo: iliaal/fastjson
      prefer-stable: true
    metadata:
      license-files: [LICENSE]
  php-extension:
    os:
      - Linux
      - Darwin
' => 
  array (
    'ext-fastjson' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'iliaal/fastjson',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
        ),
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
      ),
    ),
  ),
  'ext-gearman:
  type: php-extension
  artifact:
    source:
      type: ghtar
      repo: php/pecl-networking-gearman
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  depends:
    - libgearman
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: \'--with-gearman@shared_path_suffix@\'
' => 
  array (
    'ext-gearman' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'php/pecl-networking-gearman',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'depends' => 
      array (
        0 => 'libgearman',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => '--with-gearman@shared_path_suffix@',
      ),
    ),
  ),
  'ext-glfw:
  type: php-extension
  artifact: glfw
  depends:
    - glfw
  php-extension:
    arg-type@unix: \'--enable-glfw --with-glfw-dir=@build_root_path@\'
' => 
  array (
    'ext-glfw' => 
    array (
      'type' => 'php-extension',
      'artifact' => 'glfw',
      'depends' => 
      array (
        0 => 'glfw',
      ),
      'php-extension' => 
      array (
        'arg-type@unix' => '--enable-glfw --with-glfw-dir=@build_root_path@',
      ),
    ),
  ),
  'ext-gmssl:
  type: php-extension
  artifact:
    source:
      type: ghtar
      repo: gmssl/GmSSL-PHP
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  depends:
    - gmssl
  php-extension:
    arg-type: with-path
' => 
  array (
    'ext-gmssl' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'gmssl/GmSSL-PHP',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'depends' => 
      array (
        0 => 'gmssl',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'with-path',
      ),
    ),
  ),
  'ext-grpc:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: grpc/grpc-php-ext
    metadata:
      license-files: [LICENSE]
      license: Apache-2.0
  depends:
    - grpc
  lang: cpp
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type@unix: enable-path
' => 
  array (
    'ext-grpc' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'grpc/grpc-php-ext',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'Apache-2.0',
        ),
      ),
      'depends' => 
      array (
        0 => 'grpc',
      ),
      'lang' => 'cpp',
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type@unix' => 'enable-path',
      ),
    ),
  ),
  'ext-http:
  type: php-extension
  artifact:
    source:
      type: ghtar
      repo: m6w6/ext-http
      match: \'v?[4-9]\\.\\d+\\.\\d+$\'
      query: \'?per_page=100\'
    metadata:
      license-files: [LICENSE]
      license: BSD-2-Clause
  depends:
    - ext-raphf
    - curl
    - zlib
    - brotli
  suggests:
    - ext-iconv
    - icu
    - idn2
    - libevent
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: custom
' => 
  array (
    'ext-http' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'm6w6/ext-http',
          'match' => 'v?[4-9]\\.\\d+\\.\\d+$',
          'query' => '?per_page=100',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-2-Clause',
        ),
      ),
      'depends' => 
      array (
        0 => 'ext-raphf',
        1 => 'curl',
        2 => 'zlib',
        3 => 'brotli',
      ),
      'suggests' => 
      array (
        0 => 'ext-iconv',
        1 => 'icu',
        2 => 'idn2',
        3 => 'libevent',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => 'custom',
      ),
    ),
  ),
  'ext-igbinary:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: igbinary/igbinary
      prefer-stable: false
    metadata:
      license-files: [COPYING]
      license: BSD-3-Clause
  suggests:
    - ext-session
    - ext-apcu
' => 
  array (
    'ext-igbinary' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'igbinary/igbinary',
          'prefer-stable' => false,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'COPYING',
          ),
          'license' => 'BSD-3-Clause',
        ),
      ),
      'suggests' => 
      array (
        0 => 'ext-session',
        1 => 'ext-apcu',
      ),
    ),
  ),
  'ext-imagick:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: imagick/imagick
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  depends:
    - imagemagick
  php-extension:
    os:
      - Linux
      - Darwin
      - Windows
    arg-type: custom
' => 
  array (
    'ext-imagick' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'imagick/imagick',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'depends' => 
      array (
        0 => 'imagemagick',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
          2 => 'Windows',
        ),
        'arg-type' => 'custom',
      ),
    ),
  ),
  'ext-imap:
  type: php-extension
  artifact:
    source:
      type: ghtagtar
      repo: php/pecl-mail-imap
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  depends:
    - imap
  suggests:
    - ext-openssl
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: custom
' => 
  array (
    'ext-imap' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'php/pecl-mail-imap',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'depends' => 
      array (
        0 => 'imap',
      ),
      'suggests' => 
      array (
        0 => 'ext-openssl',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => 'custom',
      ),
    ),
  ),
  'ext-inotify:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: arnaud-lb/inotify
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  php-extension:
    os:
      - Linux
' => 
  array (
    'ext-inotify' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'arnaud-lb/inotify',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
        ),
      ),
    ),
  ),
  'ext-lz4:
  type: php-extension
  artifact:
    source:
      type: git
      url: \'https://github.com/kjdev/php-ext-lz4.git\'
      rev: master
    metadata:
      license-files: [LICENSE]
      license: MIT
  depends:
    - liblz4
  php-extension:
    arg-type@unix: \'--enable-lz4=@shared_suffix@ --with-lz4-includedir=@build_root_path@\'
    arg-type@windows: \'--enable-lz4\'
' => 
  array (
    'ext-lz4' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'url' => 'https://github.com/kjdev/php-ext-lz4.git',
          'rev' => 'master',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'MIT',
        ),
      ),
      'depends' => 
      array (
        0 => 'liblz4',
      ),
      'php-extension' => 
      array (
        'arg-type@unix' => '--enable-lz4=@shared_suffix@ --with-lz4-includedir=@build_root_path@',
        'arg-type@windows' => '--enable-lz4',
      ),
    ),
  ),
  'ext-maxminddb:
  type: php-extension
  artifact:
    source:
      type: pecl
      name: maxminddb
    metadata:
      license-files: [LICENSE]
      license: Apache-2.0
  depends:
    - libmaxminddb
  php-extension:
    arg-type: with
' => 
  array (
    'ext-maxminddb' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pecl',
          'name' => 'maxminddb',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'Apache-2.0',
        ),
      ),
      'depends' => 
      array (
        0 => 'libmaxminddb',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'with',
      ),
    ),
  ),
  'ext-memcache:
  type: php-extension
  artifact:
    source:
      type: ghtar
      repo: websupport-sk/pecl-memcache
    metadata:
      license-files: [LICENSE]
      license: PHP-3.0
  depends:
    - ext-zlib
    - ext-session
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: \'--enable-memcache@shared_suffix@ --with-zlib-dir=@build_root_path@\'
' => 
  array (
    'ext-memcache' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'websupport-sk/pecl-memcache',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.0',
        ),
      ),
      'depends' => 
      array (
        0 => 'ext-zlib',
        1 => 'ext-session',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => '--enable-memcache@shared_suffix@ --with-zlib-dir=@build_root_path@',
      ),
    ),
  ),
  'ext-memcached:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: php-memcached/php-memcached
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  depends:
    - libmemcached
  depends@unix:
    - libmemcached
    - fastlz
    - ext-session
    - ext-zlib
  suggests:
    - zstd
    - ext-igbinary
    - ext-msgpack
    - ext-session
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: \'--enable-memcached@shared_suffix@ --with-zlib-dir=@build_root_path@\'
' => 
  array (
    'ext-memcached' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'php-memcached/php-memcached',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'depends' => 
      array (
        0 => 'libmemcached',
      ),
      'depends@unix' => 
      array (
        0 => 'libmemcached',
        1 => 'fastlz',
        2 => 'ext-session',
        3 => 'ext-zlib',
      ),
      'suggests' => 
      array (
        0 => 'zstd',
        1 => 'ext-igbinary',
        2 => 'ext-msgpack',
        3 => 'ext-session',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => '--enable-memcached@shared_suffix@ --with-zlib-dir=@build_root_path@',
      ),
    ),
  ),
  'ext-mongodb:
  type: php-extension
  artifact:
    source:
      type: ghrel
      repo: mongodb/mongo-php-driver
      match: mongodb.+\\.tgz
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  depends@windows:
    - ext-openssl
  suggests@unix:
    - icu
    - openssl
    - zstd
    - zlib
  frameworks:
    - CoreFoundation
    - Security
  php-extension:
    arg-type@unix: custom
    arg-type@windows: \'--enable-mongodb --with-mongodb-client-side-encryption\'
' => 
  array (
    'ext-mongodb' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'mongodb/mongo-php-driver',
          'match' => 'mongodb.+\\.tgz',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'depends@windows' => 
      array (
        0 => 'ext-openssl',
      ),
      'suggests@unix' => 
      array (
        0 => 'icu',
        1 => 'openssl',
        2 => 'zstd',
        3 => 'zlib',
      ),
      'frameworks' => 
      array (
        0 => 'CoreFoundation',
        1 => 'Security',
      ),
      'php-extension' => 
      array (
        'arg-type@unix' => 'custom',
        'arg-type@windows' => '--enable-mongodb --with-mongodb-client-side-encryption',
      ),
    ),
  ),
  'ext-msgpack:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: msgpack/msgpack-php
    metadata:
      license-files: [LICENSE]
      license: BSD-3-Clause
  depends:
    - ext-session
  php-extension:
    arg-type@unix: with
    arg-type@windows: enable
' => 
  array (
    'ext-msgpack' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'msgpack/msgpack-php',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-3-Clause',
        ),
      ),
      'depends' => 
      array (
        0 => 'ext-session',
      ),
      'php-extension' => 
      array (
        'arg-type@unix' => 'with',
        'arg-type@windows' => 'enable',
      ),
    ),
  ),
  'ext-mysqlnd_ed25519:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: mariadb/mysqlnd_ed25519
    metadata:
      license-files: [LICENSE]
      license: BSD-3-Clause
  depends:
    - ext-mysqlnd
    - libsodium
  suggests:
    - openssl
  php-extension:
    arg-type: \'--with-mysqlnd_ed25519=@shared_suffix@\'
    build-static: false
' => 
  array (
    'ext-mysqlnd_ed25519' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'mariadb/mysqlnd_ed25519',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-3-Clause',
        ),
      ),
      'depends' => 
      array (
        0 => 'ext-mysqlnd',
        1 => 'libsodium',
      ),
      'suggests' => 
      array (
        0 => 'openssl',
      ),
      'php-extension' => 
      array (
        'arg-type' => '--with-mysqlnd_ed25519=@shared_suffix@',
        'build-static' => false,
      ),
    ),
  ),
  'ext-mysqlnd_parsec:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: mariadb/mysqlnd_parsec
    metadata:
      license-files: [LICENSE]
      license: BSD-3-Clause
  depends:
    - ext-mysqlnd
    - libsodium
    - openssl
  php-extension:
    arg-type: \'--enable-mysqlnd_parsec\'
    build-static: false
' => 
  array (
    'ext-mysqlnd_parsec' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'mariadb/mysqlnd_parsec',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-3-Clause',
        ),
      ),
      'depends' => 
      array (
        0 => 'ext-mysqlnd',
        1 => 'libsodium',
        2 => 'openssl',
      ),
      'php-extension' => 
      array (
        'arg-type' => '--enable-mysqlnd_parsec',
        'build-static' => false,
      ),
    ),
  ),
  'ext-opentelemetry:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: open-telemetry/ext-opentelemetry
      source-root: ext
    metadata:
      license-files: [LICENSE]
      license: Apache-2.0
' => 
  array (
    'ext-opentelemetry' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'open-telemetry/ext-opentelemetry',
          'source-root' => 'ext',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'Apache-2.0',
        ),
      ),
    ),
  ),
  'ext-parallel:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: pecl/parallel
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  depends@windows:
    - pthreads4w
  php-extension:
    arg-type@windows: with
' => 
  array (
    'ext-parallel' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'pecl/parallel',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'depends@windows' => 
      array (
        0 => 'pthreads4w',
      ),
      'php-extension' => 
      array (
        'arg-type@windows' => 'with',
      ),
    ),
  ),
  'ext-pcov:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: pecl/pcov
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  php-extension:
    build-static: false
    build-shared: true
' => 
  array (
    'ext-pcov' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'pecl/pcov',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'php-extension' => 
      array (
        'build-static' => false,
        'build-shared' => true,
      ),
    ),
  ),
  'ext-pdo_sqlsrv:
  type: php-extension
  artifact:
    source:
      type: pecl
      name: pdo_sqlsrv
    metadata:
      license-files: [LICENSE]
      license: MIT
  depends:
    - ext-pdo
    - ext-sqlsrv
  php-extension:
    arg-type: with
' => 
  array (
    'ext-pdo_sqlsrv' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pecl',
          'name' => 'pdo_sqlsrv',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'MIT',
        ),
      ),
      'depends' => 
      array (
        0 => 'ext-pdo',
        1 => 'ext-sqlsrv',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'with',
      ),
    ),
  ),
  'ext-protobuf:
  type: php-extension
  artifact:
    source:
      type: pecl
      name: protobuf
    metadata:
      license-files: [LICENSE]
      license: BSD-3-Clause
  php-extension:
    os:
      - Linux
      - Darwin
' => 
  array (
    'ext-protobuf' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pecl',
          'name' => 'protobuf',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-3-Clause',
        ),
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
      ),
    ),
  ),
  'ext-raphf:
  type: php-extension
  artifact:
    source:
      type: ghtar
      repo: m6w6/ext-raphf
      match: \'v?[2-9]\\.\\d+\\.\\d+$\'
      query: \'?per_page=100\'
    metadata:
      license-files: [LICENSE]
      license: BSD-2-Clause
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: enable
' => 
  array (
    'ext-raphf' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'm6w6/ext-raphf',
          'match' => 'v?[2-9]\\.\\d+\\.\\d+$',
          'query' => '?per_page=100',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-2-Clause',
        ),
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => 'enable',
      ),
    ),
  ),
  'ext-rar:
  type: php-extension
  artifact:
    source:
      type: ghrel
      repo: cataphract/php-rar
      match: rar-.+\\.tgz
      prefer-stable: true
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  lang: cpp
' => 
  array (
    'ext-rar' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghrel',
          'repo' => 'cataphract/php-rar',
          'match' => 'rar-.+\\.tgz',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'lang' => 'cpp',
    ),
  ),
  'ext-rdkafka:
  type: php-extension
  artifact:
    source:
      type: ghtar
      repo: php-rdkafka/php-rdkafka
    metadata:
      license-files: [LICENSE]
      license: MIT
  depends:
    - librdkafka
  lang: cpp
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: custom
' => 
  array (
    'ext-rdkafka' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'php-rdkafka/php-rdkafka',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'MIT',
        ),
      ),
      'depends' => 
      array (
        0 => 'librdkafka',
      ),
      'lang' => 'cpp',
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => 'custom',
      ),
    ),
  ),
  'ext-redis:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: phpredis/phpredis
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  suggests:
    - ext-session
    - ext-igbinary
    - ext-msgpack
  suggests@unix:
    - ext-session
    - ext-igbinary
    - ext-msgpack
    - zstd
    - liblz4
  php-extension:
    arg-type: custom
' => 
  array (
    'ext-redis' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'phpredis/phpredis',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'suggests' => 
      array (
        0 => 'ext-session',
        1 => 'ext-igbinary',
        2 => 'ext-msgpack',
      ),
      'suggests@unix' => 
      array (
        0 => 'ext-session',
        1 => 'ext-igbinary',
        2 => 'ext-msgpack',
        3 => 'zstd',
        4 => 'liblz4',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'custom',
      ),
    ),
  ),
  'ext-simdjson:
  type: php-extension
  artifact:
    source:
      type: pecl
      name: simdjson
    metadata:
      license-files: [LICENSE]
      license: Apache-2.0
  lang: cpp
' => 
  array (
    'ext-simdjson' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pecl',
          'name' => 'simdjson',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'Apache-2.0',
        ),
      ),
      'lang' => 'cpp',
    ),
  ),
  'ext-snappy:
  type: php-extension
  artifact:
    source:
      type: git
      url: \'https://github.com/kjdev/php-ext-snappy\'
      rev: master
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  depends:
    - snappy
  suggests:
    - ext-apcu
  lang: cpp
  php-extension:
    arg-type@unix: \'--enable-snappy --with-snappy-includedir=@build_root_path@\'
    arg-type@windows: \'--enable-snappy\'
' => 
  array (
    'ext-snappy' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'url' => 'https://github.com/kjdev/php-ext-snappy',
          'rev' => 'master',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'depends' => 
      array (
        0 => 'snappy',
      ),
      'suggests' => 
      array (
        0 => 'ext-apcu',
      ),
      'lang' => 'cpp',
      'php-extension' => 
      array (
        'arg-type@unix' => '--enable-snappy --with-snappy-includedir=@build_root_path@',
        'arg-type@windows' => '--enable-snappy',
      ),
    ),
  ),
  'ext-spx:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: noisebynorthwest/php-spx
    metadata:
      license-files: [LICENSE]
      license: GPL-3.0-or-later
  depends:
    - ext-zlib
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: \'--enable-SPX@shared_suffix@\'
' => 
  array (
    'ext-spx' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'noisebynorthwest/php-spx',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'GPL-3.0-or-later',
        ),
      ),
      'depends' => 
      array (
        0 => 'ext-zlib',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => '--enable-SPX@shared_suffix@',
      ),
    ),
  ),
  'ext-sqlsrv:
  type: php-extension
  artifact:
    source:
      type: pecl
      name: sqlsrv
    metadata:
      license-files: [LICENSE]
      license: MIT
  depends@linux:
    - unixodbc
    - ext-pcntl
  depends@macos:
    - unixodbc
  lang: cpp
' => 
  array (
    'ext-sqlsrv' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pecl',
          'name' => 'sqlsrv',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'MIT',
        ),
      ),
      'depends@linux' => 
      array (
        0 => 'unixodbc',
        1 => 'ext-pcntl',
      ),
      'depends@macos' => 
      array (
        0 => 'unixodbc',
      ),
      'lang' => 'cpp',
    ),
  ),
  'ext-ssh2:
  type: php-extension
  artifact:
    source:
      type: ghtar
      repo: php/pecl-networking-ssh2
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  depends:
    - libssh2
    - ext-openssl
    - ext-zlib
  php-extension:
    arg-type: with-path
' => 
  array (
    'ext-ssh2' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'php/pecl-networking-ssh2',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'depends' => 
      array (
        0 => 'libssh2',
        1 => 'ext-openssl',
        2 => 'ext-zlib',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'with-path',
      ),
    ),
  ),
  'ext-swoole:
  type: php-extension
  artifact:
    source:
      type: ghtar
      repo: swoole/swoole-src
      prefer-stable: true
    metadata:
      license-files: [LICENSE]
      license: Apache-2.0
  depends:
    - libcares
    - brotli
    - nghttp2
    - zlib
    - ext-openssl
    - ext-curl
  suggests:
    - zstd
    - ext-sockets
    - ext-swoole-hook-pgsql
    - ext-swoole-hook-mysql
    - ext-swoole-hook-sqlite
    - ext-swoole-hook-odbc
  suggests@linux:
    - zstd
    - liburing
    - ext-sockets
    - ext-swoole-hook-pgsql
    - ext-swoole-hook-mysql
    - ext-swoole-hook-sqlite
    - ext-swoole-hook-odbc
  lang: cpp
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: custom
ext-swoole-hook-mysql:
  type: php-extension
  depends:
    - ext-mysqlnd
    - ext-pdo
    - ext-pdo_mysql
  suggests:
    - ext-mysqli
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: none
    display-name: swoole
ext-swoole-hook-odbc:
  type: php-extension
  depends:
    - ext-pdo
    - unixodbc
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: none
    display-name: swoole
ext-swoole-hook-pgsql:
  type: php-extension
  depends:
    - ext-pgsql
    - ext-pdo
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: none
    display-name: swoole
ext-swoole-hook-sqlite:
  type: php-extension
  depends:
    - ext-sqlite3
    - ext-pdo
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: none
    display-name: swoole
' => 
  array (
    'ext-swoole' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'swoole/swoole-src',
          'prefer-stable' => true,
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'Apache-2.0',
        ),
      ),
      'depends' => 
      array (
        0 => 'libcares',
        1 => 'brotli',
        2 => 'nghttp2',
        3 => 'zlib',
        4 => 'ext-openssl',
        5 => 'ext-curl',
      ),
      'suggests' => 
      array (
        0 => 'zstd',
        1 => 'ext-sockets',
        2 => 'ext-swoole-hook-pgsql',
        3 => 'ext-swoole-hook-mysql',
        4 => 'ext-swoole-hook-sqlite',
        5 => 'ext-swoole-hook-odbc',
      ),
      'suggests@linux' => 
      array (
        0 => 'zstd',
        1 => 'liburing',
        2 => 'ext-sockets',
        3 => 'ext-swoole-hook-pgsql',
        4 => 'ext-swoole-hook-mysql',
        5 => 'ext-swoole-hook-sqlite',
        6 => 'ext-swoole-hook-odbc',
      ),
      'lang' => 'cpp',
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => 'custom',
      ),
    ),
    'ext-swoole-hook-mysql' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'ext-mysqlnd',
        1 => 'ext-pdo',
        2 => 'ext-pdo_mysql',
      ),
      'suggests' => 
      array (
        0 => 'ext-mysqli',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => 'none',
        'display-name' => 'swoole',
      ),
    ),
    'ext-swoole-hook-odbc' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'ext-pdo',
        1 => 'unixodbc',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => 'none',
        'display-name' => 'swoole',
      ),
    ),
    'ext-swoole-hook-pgsql' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'ext-pgsql',
        1 => 'ext-pdo',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => 'none',
        'display-name' => 'swoole',
      ),
    ),
    'ext-swoole-hook-sqlite' => 
    array (
      'type' => 'php-extension',
      'depends' => 
      array (
        0 => 'ext-sqlite3',
        1 => 'ext-pdo',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => 'none',
        'display-name' => 'swoole',
      ),
    ),
  ),
  'ext-swow:
  type: php-extension
  artifact:
    source:
      type: ghtar
      repo: swow/swow
      prefer-stable: true
      source-root: ext
    metadata:
      license: Apache-2.0
      license-files: [LICENSE]
  suggests:
    - openssl
    - curl
    - ext-openssl
    - ext-curl
    - postgresql
  php-extension:
    arg-type: custom
' => 
  array (
    'ext-swow' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'swow/swow',
          'prefer-stable' => true,
          'source-root' => 'ext',
        ),
        'metadata' => 
        array (
          'license' => 'Apache-2.0',
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
        ),
      ),
      'suggests' => 
      array (
        0 => 'openssl',
        1 => 'curl',
        2 => 'ext-openssl',
        3 => 'ext-curl',
        4 => 'postgresql',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'custom',
      ),
    ),
  ),
  'ext-trader:
  type: php-extension
  artifact:
    source:
      type: ghtagtar
      repo: php/pecl-math-trader
    metadata:
      license-files: [LICENSE]
      license: BSD-2-Clause
  php-extension:
    arg-type: enable
' => 
  array (
    'ext-trader' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'php/pecl-math-trader',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-2-Clause',
        ),
      ),
      'php-extension' => 
      array (
        'arg-type' => 'enable',
      ),
    ),
  ),
  'ext-uuid:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: pecl/uuid
    metadata:
      license-files: [LICENSE]
      license: LGPL-2.1-only
  depends:
    - libuuid
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: with-path
' => 
  array (
    'ext-uuid' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'pecl/uuid',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'LGPL-2.1-only',
        ),
      ),
      'depends' => 
      array (
        0 => 'libuuid',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => 'with-path',
      ),
    ),
  ),
  'ext-uv:
  type: php-extension
  artifact:
    source:
      type: ghtagtar
      repo: amphp/ext-uv
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  depends:
    - libuv
    - ext-sockets
  php-extension:
    arg-type: with-path
' => 
  array (
    'ext-uv' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'amphp/ext-uv',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'depends' => 
      array (
        0 => 'libuv',
        1 => 'ext-sockets',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'with-path',
      ),
    ),
  ),
  'ext-xdebug:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: xdebug/xdebug
      extract: ext-xdebug
    metadata:
      license-files: [LICENSE]
      license: Xdebug-1.03
  php-extension:
    os:
      - Linux
      - Darwin
    zend-extension: true
    build-static: false
    build-shared: true
    build-with-php: false
' => 
  array (
    'ext-xdebug' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'xdebug/xdebug',
          'extract' => 'ext-xdebug',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'Xdebug-1.03',
        ),
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'zend-extension' => true,
        'build-static' => false,
        'build-shared' => true,
        'build-with-php' => false,
      ),
    ),
  ),
  'ext-xhprof:
  type: php-extension
  artifact:
    source:
      type: ghtar
      repo: longxinH/xhprof
      source-root: extension
    metadata:
      license-files: [LICENSE]
      license: Apache-2.0
  depends:
    - ext-ctype
  php-extension:
    os:
      - Linux
      - Darwin
    arg-type: enable
    build-with-php: true
' => 
  array (
    'ext-xhprof' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'longxinH/xhprof',
          'source-root' => 'extension',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'Apache-2.0',
        ),
      ),
      'depends' => 
      array (
        0 => 'ext-ctype',
      ),
      'php-extension' => 
      array (
        'os' => 
        array (
          0 => 'Linux',
          1 => 'Darwin',
        ),
        'arg-type' => 'enable',
        'build-with-php' => true,
      ),
    ),
  ),
  'ext-xlswriter:
  type: php-extension
  artifact:
    source:
      type: pecl
      name: xlswriter
    metadata:
      license-files: [LICENSE]
      license: BSD-2-Clause
  depends:
    - ext-zlib
    - ext-zip
  suggests:
    - openssl
  php-extension:
    arg-type: custom
    arg-type@windows: \'--with-xlswriter\'
' => 
  array (
    'ext-xlswriter' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pecl',
          'name' => 'xlswriter',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'BSD-2-Clause',
        ),
      ),
      'depends' => 
      array (
        0 => 'ext-zlib',
        1 => 'ext-zip',
      ),
      'suggests' => 
      array (
        0 => 'openssl',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'custom',
        'arg-type@windows' => '--with-xlswriter',
      ),
    ),
  ),
  'ext-xz:
  type: php-extension
  artifact:
    source:
      type: git
      url: \'https://github.com/codemasher/php-ext-xz\'
      rev: main
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  depends:
    - xz
  php-extension:
    arg-type: with-path
    arg-type@windows: enable
' => 
  array (
    'ext-xz' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'url' => 'https://github.com/codemasher/php-ext-xz',
          'rev' => 'main',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'depends' => 
      array (
        0 => 'xz',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'with-path',
        'arg-type@windows' => 'enable',
      ),
    ),
  ),
  'ext-yac:
  type: php-extension
  artifact:
    source:
      type: ghtagtar
      repo: laruence/yac
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  depends@unix:
    - fastlz
    - ext-igbinary
  php-extension:
    arg-type@unix: \'--enable-yac@shared_suffix@ --enable-igbinary --enable-json --with-system-fastlz\'
' => 
  array (
    'ext-yac' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtagtar',
          'repo' => 'laruence/yac',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'depends@unix' => 
      array (
        0 => 'fastlz',
        1 => 'ext-igbinary',
      ),
      'php-extension' => 
      array (
        'arg-type@unix' => '--enable-yac@shared_suffix@ --enable-igbinary --enable-json --with-system-fastlz',
      ),
    ),
  ),
  'ext-yaml:
  type: php-extension
  artifact:
    source:
      type: git
      url: \'https://github.com/php/pecl-file_formats-yaml\'
      rev: php7
    metadata:
      license-files: [LICENSE]
      license: MIT
  depends:
    - libyaml
  php-extension:
    arg-type@unix: with-path
    arg-type@windows: with
' => 
  array (
    'ext-yaml' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'git',
          'url' => 'https://github.com/php/pecl-file_formats-yaml',
          'rev' => 'php7',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'MIT',
        ),
      ),
      'depends' => 
      array (
        0 => 'libyaml',
      ),
      'php-extension' => 
      array (
        'arg-type@unix' => 'with-path',
        'arg-type@windows' => 'with',
      ),
    ),
  ),
  'ext-zip:
  type: php-extension
  artifact:
    source:
      type: pie
      repo: pecl/zip
      extract: ext-zip
    metadata:
      license-files: [LICENSE]
      license: PHP-3.01
  depends:
    - libzip
  depends@windows:
    - libzip
    - zlib
    - xz
    - bzip2
  php-extension:
    arg-type: custom
    arg-type@windows: enable
' => 
  array (
    'ext-zip' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'pie',
          'repo' => 'pecl/zip',
          'extract' => 'ext-zip',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'PHP-3.01',
        ),
      ),
      'depends' => 
      array (
        0 => 'libzip',
      ),
      'depends@windows' => 
      array (
        0 => 'libzip',
        1 => 'zlib',
        2 => 'xz',
        3 => 'bzip2',
      ),
      'php-extension' => 
      array (
        'arg-type' => 'custom',
        'arg-type@windows' => 'enable',
      ),
    ),
  ),
  'ext-zstd:
  type: php-extension
  artifact:
    source:
      type: ghtar
      repo: kjdev/php-ext-zstd
    metadata:
      license-files: [LICENSE]
      license: MIT
  depends:
    - zstd
  suggests:
    - ext-apcu
  php-extension:
    arg-type: \'--enable-zstd --with-libzstd=@build_root_path@\'
    arg-type@windows: \'--enable-zstd\'
' => 
  array (
    'ext-zstd' => 
    array (
      'type' => 'php-extension',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'ghtar',
          'repo' => 'kjdev/php-ext-zstd',
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'LICENSE',
          ),
          'license' => 'MIT',
        ),
      ),
      'depends' => 
      array (
        0 => 'zstd',
      ),
      'suggests' => 
      array (
        0 => 'ext-apcu',
      ),
      'php-extension' => 
      array (
        'arg-type' => '--enable-zstd --with-libzstd=@build_root_path@',
        'arg-type@windows' => '--enable-zstd',
      ),
    ),
  ),
  '7za-win:
  type: tool
  artifact:
    binary:
      windows-x86_64: { type: url, url: \'https://dl.static-php.dev/v3/tools/7zip/7za.exe\', extract: \'{pkg_root_path}/bin/7za.exe\' }
  tool:
    provides:
      - 7za.exe
    binary-subdir: bin
' => 
  array (
    '7za-win' => 
    array (
      'type' => 'tool',
      'artifact' => 
      array (
        'binary' => 
        array (
          'windows-x86_64' => 
          array (
            'type' => 'url',
            'url' => 'https://dl.static-php.dev/v3/tools/7zip/7za.exe',
            'extract' => '{pkg_root_path}/bin/7za.exe',
          ),
        ),
      ),
      'tool' => 
      array (
        'provides' => 
        array (
          0 => '7za.exe',
        ),
        'binary-subdir' => 'bin',
      ),
    ),
  ),
  'go-win:
  type: tool
  artifact:
    binary: custom
  env:
    GOROOT: \'{pkg_root_path}/go-win\'
    GOBIN: \'{pkg_root_path}/go-win/bin\'
    GOPATH: \'{pkg_root_path}/go-win/gopath\'
  path@windows:
    - \'{pkg_root_path}/go-win/bin\'
  tool:
    provides:
      - go.exe
      - gofmt.exe
    binary-subdir: go-win/bin
' => 
  array (
    'go-win' => 
    array (
      'type' => 'tool',
      'artifact' => 
      array (
        'binary' => 'custom',
      ),
      'env' => 
      array (
        'GOROOT' => '{pkg_root_path}/go-win',
        'GOBIN' => '{pkg_root_path}/go-win/bin',
        'GOPATH' => '{pkg_root_path}/go-win/gopath',
      ),
      'path@windows' => 
      array (
        0 => '{pkg_root_path}/go-win/bin',
      ),
      'tool' => 
      array (
        'provides' => 
        array (
          0 => 'go.exe',
          1 => 'gofmt.exe',
        ),
        'binary-subdir' => 'go-win/bin',
      ),
    ),
  ),
  'go-xcaddy:
  type: tool
  artifact:
    binary: custom
  env:
    GOROOT: \'{pkg_root_path}/go-xcaddy\'
    GOBIN: \'{pkg_root_path}/go-xcaddy/bin\'
    GOPATH: \'{pkg_root_path}/go-xcaddy/go\'
  path@unix:
    - \'{pkg_root_path}/go-xcaddy/bin\'
  tool:
    provides:
      - go
      - gofmt
    binary-subdir: go-xcaddy/bin
' => 
  array (
    'go-xcaddy' => 
    array (
      'type' => 'tool',
      'artifact' => 
      array (
        'binary' => 'custom',
      ),
      'env' => 
      array (
        'GOROOT' => '{pkg_root_path}/go-xcaddy',
        'GOBIN' => '{pkg_root_path}/go-xcaddy/bin',
        'GOPATH' => '{pkg_root_path}/go-xcaddy/go',
      ),
      'path@unix' => 
      array (
        0 => '{pkg_root_path}/go-xcaddy/bin',
      ),
      'tool' => 
      array (
        'provides' => 
        array (
          0 => 'go',
          1 => 'gofmt',
        ),
        'binary-subdir' => 'go-xcaddy/bin',
      ),
    ),
  ),
  'jom:
  type: tool
  artifact:
    binary:
      windows-x86_64: { type: url, url: \'https://download.qt.io/official_releases/jom/jom.zip\', extract: \'{pkg_root_path}/jom\' }
  path@windows:
    - \'{pkg_root_path}\\jom\'
  tool:
    provides:
      - jom.exe
    binary-subdir: jom
' => 
  array (
    'jom' => 
    array (
      'type' => 'tool',
      'artifact' => 
      array (
        'binary' => 
        array (
          'windows-x86_64' => 
          array (
            'type' => 'url',
            'url' => 'https://download.qt.io/official_releases/jom/jom.zip',
            'extract' => '{pkg_root_path}/jom',
          ),
        ),
      ),
      'path@windows' => 
      array (
        0 => '{pkg_root_path}\\jom',
      ),
      'tool' => 
      array (
        'provides' => 
        array (
          0 => 'jom.exe',
        ),
        'binary-subdir' => 'jom',
      ),
    ),
  ),
  'llvm-tools:
  type: tool
  artifact:
    source:
      type: custom
    binary:
      linux-x86_64: { type: custom, base-url: \'https://dl.static-php.dev/v3/deps/llvm-tools/\' }
      linux-aarch64: { type: custom, base-url: \'https://dl.static-php.dev/v3/deps/llvm-tools/\' }
    metadata:
      license-files: [llvm/LICENSE.TXT]
      license: Apache-2.0-with-LLVM-exception
  tool:
    provides:
      - llvm-objcopy
      - llvm-strip
      - llvm-profdata
    install-root: \'{pkg_root_path}/llvm-tools\'
    binary-subdir: bin
' => 
  array (
    'llvm-tools' => 
    array (
      'type' => 'tool',
      'artifact' => 
      array (
        'source' => 
        array (
          'type' => 'custom',
        ),
        'binary' => 
        array (
          'linux-x86_64' => 
          array (
            'type' => 'custom',
            'base-url' => 'https://dl.static-php.dev/v3/deps/llvm-tools/',
          ),
          'linux-aarch64' => 
          array (
            'type' => 'custom',
            'base-url' => 'https://dl.static-php.dev/v3/deps/llvm-tools/',
          ),
        ),
        'metadata' => 
        array (
          'license-files' => 
          array (
            0 => 'llvm/LICENSE.TXT',
          ),
          'license' => 'Apache-2.0-with-LLVM-exception',
        ),
      ),
      'tool' => 
      array (
        'provides' => 
        array (
          0 => 'llvm-objcopy',
          1 => 'llvm-strip',
          2 => 'llvm-profdata',
        ),
        'install-root' => '{pkg_root_path}/llvm-tools',
        'binary-subdir' => 'bin',
      ),
    ),
  ),
  'meson:
  type: tool
  artifact:
    binary:
      windows-x86_64: { type: url, url: \'https://github.com/mesonbuild/meson/releases/download/1.11.1/meson-1.11.1-py3-none-any.whl\', extract: \'{pkg_root_path}/meson/meson-1.11.1-py3-none-any.whl\' }
  path@windows:
    - \'{pkg_root_path}\\meson\'
  tool:
    provides:
      - meson.bat
    binary-subdir: meson
' => 
  array (
    'meson' => 
    array (
      'type' => 'tool',
      'artifact' => 
      array (
        'binary' => 
        array (
          'windows-x86_64' => 
          array (
            'type' => 'url',
            'url' => 'https://github.com/mesonbuild/meson/releases/download/1.11.1/meson-1.11.1-py3-none-any.whl',
            'extract' => '{pkg_root_path}/meson/meson-1.11.1-py3-none-any.whl',
          ),
        ),
      ),
      'path@windows' => 
      array (
        0 => '{pkg_root_path}\\meson',
      ),
      'tool' => 
      array (
        'provides' => 
        array (
          0 => 'meson.bat',
        ),
        'binary-subdir' => 'meson',
      ),
    ),
  ),
  'nasm:
  type: tool
  artifact:
    binary:
      windows-x86_64: { type: url, url: \'https://dl.static-php.dev/static-php-cli/deps/nasm/nasm-2.16.01-win64.zip\', extract: { nasm.exe: \'{pkg_root_path}/bin/nasm.exe\', ndisasm.exe: \'{pkg_root_path}/bin/ndisasm.exe\' } }
  tool:
    provides:
      - nasm.exe
      - ndisasm.exe
    binary-subdir: bin
' => 
  array (
    'nasm' => 
    array (
      'type' => 'tool',
      'artifact' => 
      array (
        'binary' => 
        array (
          'windows-x86_64' => 
          array (
            'type' => 'url',
            'url' => 'https://dl.static-php.dev/static-php-cli/deps/nasm/nasm-2.16.01-win64.zip',
            'extract' => 
            array (
              'nasm.exe' => '{pkg_root_path}/bin/nasm.exe',
              'ndisasm.exe' => '{pkg_root_path}/bin/ndisasm.exe',
            ),
          ),
        ),
      ),
      'tool' => 
      array (
        'provides' => 
        array (
          0 => 'nasm.exe',
          1 => 'ndisasm.exe',
        ),
        'binary-subdir' => 'bin',
      ),
    ),
  ),
  'ninja:
  type: tool
  artifact:
    binary:
      windows-x86_64: { type: url, url: \'https://github.com/ninja-build/ninja/releases/download/v1.13.2/ninja-win.zip\', extract: { ninja.exe: \'{pkg_root_path}/bin/ninja.exe\' } }
  tool:
    provides:
      - ninja.exe
    binary-subdir: bin
' => 
  array (
    'ninja' => 
    array (
      'type' => 'tool',
      'artifact' => 
      array (
        'binary' => 
        array (
          'windows-x86_64' => 
          array (
            'type' => 'url',
            'url' => 'https://github.com/ninja-build/ninja/releases/download/v1.13.2/ninja-win.zip',
            'extract' => 
            array (
              'ninja.exe' => '{pkg_root_path}/bin/ninja.exe',
            ),
          ),
        ),
      ),
      'tool' => 
      array (
        'provides' => 
        array (
          0 => 'ninja.exe',
        ),
        'binary-subdir' => 'bin',
      ),
    ),
  ),
  'pkg-config:
  type: tool
  artifact:
    source: \'https://dl.static-php.dev/static-php-cli/deps/pkg-config/pkg-config-0.29.2.tar.gz\'
    binary:
      linux-x86_64: { type: ghrel, repo: static-php/hosted, match: pkg-config-x86_64-linux-musl-1.2.5.txz, extract: { bin/pkg-config: \'{pkg_root_path}/bin/pkg-config\' } }
      linux-aarch64: { type: ghrel, repo: static-php/hosted, match: pkg-config-aarch64-linux-musl-1.2.5.txz, extract: { bin/pkg-config: \'{pkg_root_path}/bin/pkg-config\' } }
      macos-x86_64: { type: ghrel, repo: static-php/hosted, match: pkg-config-x86_64-darwin.txz, extract: { bin/pkg-config: \'{pkg_root_path}/bin/pkg-config\' } }
      macos-aarch64: { type: ghrel, repo: static-php/hosted, match: pkg-config-aarch64-darwin.txz, extract: { bin/pkg-config: \'{pkg_root_path}/bin/pkg-config\' } }
  tool:
    provides:
      - pkg-config
    binary-subdir: bin
' => 
  array (
    'pkg-config' => 
    array (
      'type' => 'tool',
      'artifact' => 
      array (
        'source' => 'https://dl.static-php.dev/static-php-cli/deps/pkg-config/pkg-config-0.29.2.tar.gz',
        'binary' => 
        array (
          'linux-x86_64' => 
          array (
            'type' => 'ghrel',
            'repo' => 'static-php/hosted',
            'match' => 'pkg-config-x86_64-linux-musl-1.2.5.txz',
            'extract' => 
            array (
              'bin/pkg-config' => '{pkg_root_path}/bin/pkg-config',
            ),
          ),
          'linux-aarch64' => 
          array (
            'type' => 'ghrel',
            'repo' => 'static-php/hosted',
            'match' => 'pkg-config-aarch64-linux-musl-1.2.5.txz',
            'extract' => 
            array (
              'bin/pkg-config' => '{pkg_root_path}/bin/pkg-config',
            ),
          ),
          'macos-x86_64' => 
          array (
            'type' => 'ghrel',
            'repo' => 'static-php/hosted',
            'match' => 'pkg-config-x86_64-darwin.txz',
            'extract' => 
            array (
              'bin/pkg-config' => '{pkg_root_path}/bin/pkg-config',
            ),
          ),
          'macos-aarch64' => 
          array (
            'type' => 'ghrel',
            'repo' => 'static-php/hosted',
            'match' => 'pkg-config-aarch64-darwin.txz',
            'extract' => 
            array (
              'bin/pkg-config' => '{pkg_root_path}/bin/pkg-config',
            ),
          ),
        ),
      ),
      'tool' => 
      array (
        'provides' => 
        array (
          0 => 'pkg-config',
        ),
        'binary-subdir' => 'bin',
      ),
    ),
  ),
  'protoc:
  type: tool
  artifact:
    binary:
      linux-x86_64: { type: ghrel, repo: protocolbuffers/protobuf, match: \'protoc-([0-9.]+)-linux-x86_64\\.zip\', extract: \'{pkg_root_path}/protoc\' }
      linux-aarch64: { type: ghrel, repo: protocolbuffers/protobuf, match: \'protoc-([0-9.]+)-linux-aarch_64\\.zip\', extract: \'{pkg_root_path}/protoc\' }
  path:
    - \'{pkg_root_path}/protoc/bin\'
  tool:
    provides:
      - protoc
    binary-subdir: protoc/bin
' => 
  array (
    'protoc' => 
    array (
      'type' => 'tool',
      'artifact' => 
      array (
        'binary' => 
        array (
          'linux-x86_64' => 
          array (
            'type' => 'ghrel',
            'repo' => 'protocolbuffers/protobuf',
            'match' => 'protoc-([0-9.]+)-linux-x86_64\\.zip',
            'extract' => '{pkg_root_path}/protoc',
          ),
          'linux-aarch64' => 
          array (
            'type' => 'ghrel',
            'repo' => 'protocolbuffers/protobuf',
            'match' => 'protoc-([0-9.]+)-linux-aarch_64\\.zip',
            'extract' => '{pkg_root_path}/protoc',
          ),
        ),
      ),
      'path' => 
      array (
        0 => '{pkg_root_path}/protoc/bin',
      ),
      'tool' => 
      array (
        'provides' => 
        array (
          0 => 'protoc',
        ),
        'binary-subdir' => 'protoc/bin',
      ),
    ),
  ),
  'python-win:
  type: tool
  artifact:
    binary: custom
  tool:
    provides:
      - python.exe
    binary-subdir: python-win/tools
' => 
  array (
    'python-win' => 
    array (
      'type' => 'tool',
      'artifact' => 
      array (
        'binary' => 'custom',
      ),
      'tool' => 
      array (
        'provides' => 
        array (
          0 => 'python.exe',
        ),
        'binary-subdir' => 'python-win/tools',
      ),
    ),
  ),
  'strawberry-perl:
  type: tool
  artifact:
    binary:
      windows-x86_64: { type: url, url: \'https://github.com/StrawberryPerl/Perl-Dist-Strawberry/releases/download/SP_5380_5361/strawberry-perl-5.38.0.1-64bit-portable.zip\', extract: \'{pkg_root_path}/strawberry-perl\' }
  tool:
    provides:
      - perl.exe
    binary-subdir: strawberry-perl/perl/bin
' => 
  array (
    'strawberry-perl' => 
    array (
      'type' => 'tool',
      'artifact' => 
      array (
        'binary' => 
        array (
          'windows-x86_64' => 
          array (
            'type' => 'url',
            'url' => 'https://github.com/StrawberryPerl/Perl-Dist-Strawberry/releases/download/SP_5380_5361/strawberry-perl-5.38.0.1-64bit-portable.zip',
            'extract' => '{pkg_root_path}/strawberry-perl',
          ),
        ),
      ),
      'tool' => 
      array (
        'provides' => 
        array (
          0 => 'perl.exe',
        ),
        'binary-subdir' => 'strawberry-perl/perl/bin',
      ),
    ),
  ),
  'upx:
  type: tool
  artifact:
    binary:
      linux-x86_64: { type: ghrel, repo: upx/upx, match: upx.+-amd64_linux\\.tar\\.xz, extract: { upx: \'{pkg_root_path}/bin/upx\' } }
      linux-aarch64: { type: ghrel, repo: upx/upx, match: upx.+-arm64_linux\\.tar\\.xz, extract: { upx: \'{pkg_root_path}/bin/upx\' } }
      windows-x86_64: { type: ghrel, repo: upx/upx, match: upx.+-win64\\.zip, extract: { upx.exe: \'{pkg_root_path}/bin/upx.exe\' } }
  tool:
    provides:
      - upx
    provides@windows:
      - upx.exe
    binary-subdir: bin
' => 
  array (
    'upx' => 
    array (
      'type' => 'tool',
      'artifact' => 
      array (
        'binary' => 
        array (
          'linux-x86_64' => 
          array (
            'type' => 'ghrel',
            'repo' => 'upx/upx',
            'match' => 'upx.+-amd64_linux\\.tar\\.xz',
            'extract' => 
            array (
              'upx' => '{pkg_root_path}/bin/upx',
            ),
          ),
          'linux-aarch64' => 
          array (
            'type' => 'ghrel',
            'repo' => 'upx/upx',
            'match' => 'upx.+-arm64_linux\\.tar\\.xz',
            'extract' => 
            array (
              'upx' => '{pkg_root_path}/bin/upx',
            ),
          ),
          'windows-x86_64' => 
          array (
            'type' => 'ghrel',
            'repo' => 'upx/upx',
            'match' => 'upx.+-win64\\.zip',
            'extract' => 
            array (
              'upx.exe' => '{pkg_root_path}/bin/upx.exe',
            ),
          ),
        ),
      ),
      'tool' => 
      array (
        'provides' => 
        array (
          0 => 'upx',
        ),
        'provides@windows' => 
        array (
          0 => 'upx.exe',
        ),
        'binary-subdir' => 'bin',
      ),
    ),
  ),
  'vswhere:
  type: tool
  artifact:
    binary:
      windows-x86_64: { type: url, url: \'https://github.com/microsoft/vswhere/releases/download/3.1.7/vswhere.exe\', extract: \'{pkg_root_path}/bin/vswhere.exe\' }
  tool:
    provides:
      - vswhere.exe
    binary-subdir: bin
' => 
  array (
    'vswhere' => 
    array (
      'type' => 'tool',
      'artifact' => 
      array (
        'binary' => 
        array (
          'windows-x86_64' => 
          array (
            'type' => 'url',
            'url' => 'https://github.com/microsoft/vswhere/releases/download/3.1.7/vswhere.exe',
            'extract' => '{pkg_root_path}/bin/vswhere.exe',
          ),
        ),
      ),
      'tool' => 
      array (
        'provides' => 
        array (
          0 => 'vswhere.exe',
        ),
        'binary-subdir' => 'bin',
      ),
    ),
  ),
  'winflexbison:
  type: tool
  artifact:
    binary:
      windows-x86_64: { type: url, url: \'https://github.com/lexxmark/winflexbison/releases/download/v2.5.25/win_flex_bison-2.5.25.zip\', extract: \'{pkg_root_path}/winflexbison\' }
  path@windows:
    - \'{pkg_root_path}\\winflexbison\'
  tool:
    provides:
      - win_flex.exe
      - win_bison.exe
    binary-subdir: winflexbison
' => 
  array (
    'winflexbison' => 
    array (
      'type' => 'tool',
      'artifact' => 
      array (
        'binary' => 
        array (
          'windows-x86_64' => 
          array (
            'type' => 'url',
            'url' => 'https://github.com/lexxmark/winflexbison/releases/download/v2.5.25/win_flex_bison-2.5.25.zip',
            'extract' => '{pkg_root_path}/winflexbison',
          ),
        ),
      ),
      'path@windows' => 
      array (
        0 => '{pkg_root_path}\\winflexbison',
      ),
      'tool' => 
      array (
        'provides' => 
        array (
          0 => 'win_flex.exe',
          1 => 'win_bison.exe',
        ),
        'binary-subdir' => 'winflexbison',
      ),
    ),
  ),
  'zig:
  type: tool
  artifact:
    binary: custom
  tool:
    provides:
      - zig
      - zig-cc
      - zig-c++
      - zig-ar
      - zig-ld.lld
      - zig-ranlib
      - zig-objcopy
    binary-subdir: zig
' => 
  array (
    'zig' => 
    array (
      'type' => 'tool',
      'artifact' => 
      array (
        'binary' => 'custom',
      ),
      'tool' => 
      array (
        'provides' => 
        array (
          0 => 'zig',
          1 => 'zig-cc',
          2 => 'zig-c++',
          3 => 'zig-ar',
          4 => 'zig-ld.lld',
          5 => 'zig-ranlib',
          6 => 'zig-objcopy',
        ),
        'binary-subdir' => 'zig',
      ),
    ),
  ),
  'glfw:
  metadata:
    license-files:
      - LICENSE
    license: MIT
  source:
    type: git
    url: \'https://github.com/mario-deluna/php-glfw\'
    rev: master
' => 
  array (
    'glfw' => 
    array (
      'metadata' => 
      array (
        'license-files' => 
        array (
          0 => 'LICENSE',
        ),
        'license' => 'MIT',
      ),
      'source' => 
      array (
        'type' => 'git',
        'url' => 'https://github.com/mario-deluna/php-glfw',
        'rev' => 'master',
      ),
    ),
  ),
  'musl-wrapper:
  source: \'https://musl.libc.org/releases/musl-1.2.5.tar.gz\'
' => 
  array (
    'musl-wrapper' => 
    array (
      'source' => 'https://musl.libc.org/releases/musl-1.2.5.tar.gz',
    ),
  ),
  'ncurses:
  metadata:
    license-files:
      - COPYING
  source:
    type: filelist
    url: \'https://ftp.gnu.org/gnu/ncurses/\'
    regex: \'/href="(?<file>ncurses-(?<version>[^"]+)\\.tar\\.gz)"/\'
  source-mirror:
    type: filelist
    url: \'https://ftpmirror.gnu.org/gnu/ncurses/\'
    regex: \'/href="(?<file>ncurses-(?<version>[^"]+)\\.tar\\.gz)"/\'
' => 
  array (
    'ncurses' => 
    array (
      'metadata' => 
      array (
        'license-files' => 
        array (
          0 => 'COPYING',
        ),
      ),
      'source' => 
      array (
        'type' => 'filelist',
        'url' => 'https://ftp.gnu.org/gnu/ncurses/',
        'regex' => '/href="(?<file>ncurses-(?<version>[^"]+)\\.tar\\.gz)"/',
      ),
      'source-mirror' => 
      array (
        'type' => 'filelist',
        'url' => 'https://ftpmirror.gnu.org/gnu/ncurses/',
        'regex' => '/href="(?<file>ncurses-(?<version>[^"]+)\\.tar\\.gz)"/',
      ),
    ),
  ),
  'php-src:
  metadata:
    license-files:
      - LICENSE
    license: PHP-3.01
  source:
    type: php-release
    domain: \'https://www.php.net\'
  source-mirror:
    type: php-release
    domain: \'https://phpmirror.static-php.dev\'
' => 
  array (
    'php-src' => 
    array (
      'metadata' => 
      array (
        'license-files' => 
        array (
          0 => 'LICENSE',
        ),
        'license' => 'PHP-3.01',
      ),
      'source' => 
      array (
        'type' => 'php-release',
        'domain' => 'https://www.php.net',
      ),
      'source-mirror' => 
      array (
        'type' => 'php-release',
        'domain' => 'https://phpmirror.static-php.dev',
      ),
    ),
  ),
);
