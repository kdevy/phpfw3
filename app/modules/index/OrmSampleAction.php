<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

use Framework\Action;
use Framework\middlewares\ContextsSettingsMiddleware;
use Psr\Http\Message\ResponseInterface;

class OrmSampleAction extends Action
{
    public function __invoke(): ResponseInterface
    {
        $gets = $this->request->getQueryParams();
        $table = $gets["table"] ?? null;

        $html = "no table";
        if ($table) {
            $fieldNames = DB::getSchemaBuilder()->getColumnListing($table);
            $result = DB::table($table)->get()->toArray();

            $html = <<< EOL
            <table border="1">
                <thead>
                    <tr>
            EOL;

            foreach($fieldNames as $fieldName) {
                $html .= "<th>{$fieldName}</th>";
            }

            $html .= <<< EOL
                    </tr>
                </thead>
                <tbody>
            EOL;

            foreach($result as $rowCount => $row) {
                $html .= "<tr>";
                foreach($row as $valueCount => $value) {
                    $html .= "<td>{$value}</td>";
                }
                $html .= "</tr>";
            }

            $html .= <<< EOL
                </tbody>
            </table>
            EOL;
        }

        $contexts = $this->request->getAttribute(ContextsSettingsMiddleware::ATTRIBUTE_NAME);
        $contexts["table"] = $html;
        return $this->templateResponder->response($contexts);
    }
}