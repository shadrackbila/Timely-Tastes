<?php

declare(strict_types=1);

namespace Drupal\Tests\Core\Access;

use Drupal\Core\Access\AccessGroupAnd;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\Tests\UnitTestCase;

/**
 * Tests accessible groups.
 *
 * @group Access
 */
class AccessGroupAndTest extends UnitTestCase {

  use AccessibleTestingTrait;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->account = $this->prophesize(AccountInterface::class)->reveal();
  }

  /**
   * @covers \Drupal\Core\Access\AccessGroupAnd
   */
  public function testGroups(): void {
    $allowedAccessible = $this->createAccessibleDouble(AccessResult::allowed());
    $forbiddenAccessible = $this->createAccessibleDouble(AccessResult::forbidden());
    $neutralAccessible = $this->createAccessibleDouble(AccessResult::neutral());

    // Ensure that groups with no dependencies return a neutral access result.
    $this->assertTrue((new AccessGroupAnd())->access('view', $this->account, TRUE)->isNeutral());

    $andNeutral = new AccessGroupAnd();
    $andNeutral->addDependency($allowedAccessible)->addDependency($neutralAccessible);
    $this->assertTrue($andNeutral->access('view', $this->account, TRUE)->isNeutral());

    $andForbidden = $andNeutral;
    $andForbidden->addDependency($forbiddenAccessible);
    $this->assertTrue($andForbidden->access('view', $this->account, TRUE)->isForbidden());

    // Ensure that groups added to other groups works.
    $andGroupsForbidden = new AccessGroupAnd();
    $andGroupsForbidden->addDependency($andNeutral)->addDependency($andForbidden);
    $this->assertTrue($andGroupsForbidden->access('view', $this->account, TRUE)->isForbidden());
    // Ensure you can add a non-group accessible object.
    $andGroupsForbidden->addDependency($allowedAccessible);
    $this->assertTrue($andGroupsForbidden->access('view', $this->account, TRUE)->isForbidden());
  }

}
