#!/bin/bash

# e 何かのエラーが発生した時点で、処理を中断
# u 未定義の変数を使ったらエラー
# x 実行したコマンドを標準エラーに出力
set -eux;

# 環境変数の設定
cp -a .env.example .env
# イメージをビルド
docker-compose build
# ライブラリインストール、APP キー生成、マイグレーション実行
docker-compose run --rm app sh -c 'composer install && php artisan key:generate && php artisan migrate --seed'
# テスト環境の作成
docker-compose run --rm app sh -c 'php artisan migrate --env=testing'
